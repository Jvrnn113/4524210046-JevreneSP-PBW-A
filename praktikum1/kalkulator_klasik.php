<?php
// kalkulator1.php - Praktikum Pemrograman Berbasis Web (PBW)
// Modul Kalkulator Klasik dengan Pemrosesan Backend PHP & Evaluasi Ekspresi Matematika

if (!class_exists('MathParser')) {
    class MathParser {
        private $tokens = [];
        private $pos = 0;
        public $error = null;

        public function __construct($expr) {
            $this->tokenize($expr);
        }

        private function tokenize($expr) {
            // Normalisasi simbol perkalian dan pembagian klasik
            $expr = str_replace(['×', 'x', 'X', '÷', ':', '−'], ['*', '*', '*', '/', '/', '-'], $expr);
            $tokens = [];
            $len = strlen($expr);
            $i = 0;
            while ($i < $len) {
                $ch = $expr[$i];
                if (ctype_space($ch)) {
                    $i++;
                    continue;
                }
                if (strpos('+-*/%()', $ch) !== false) {
                    $tokens[] = $ch;
                    $i++;
                } elseif (ctype_digit($ch) || $ch === '.') {
                    $numStr = '';
                    while ($i < $len && (ctype_digit($expr[$i]) || $expr[$i] === '.')) {
                        $numStr .= $expr[$i];
                        $i++;
                    }
                    $tokens[] = (float)$numStr;
                } else {
                    $this->error = 'Karakter tidak valid: ' . $ch;
                    return;
                }
            }
            $this->tokens = $tokens;
        }

        public function evaluate() {
            if ($this->error) return null;
            if (empty($this->tokens)) {
                $this->error = 'Ekspresi kosong.';
                return null;
            }
            $res = $this->parseExpression();
            if ($this->pos < count($this->tokens) && !$this->error) {
                $this->error = 'Format ekspresi tidak valid di sekitar: ' . $this->tokens[$this->pos];
                return null;
            }
            return $this->error ? null : $res;
        }

        // parseExpression: menangani penambahan (+) dan pengurangan (-) dengan dukungan persen
        private function parseExpression() {
            $left = $this->parseTerm();
            $val = $left['val'];

            while ($this->pos < count($this->tokens) && !$this->error) {
                $op = $this->tokens[$this->pos];
                if ($op === '+' || $op === '-') {
                    $this->pos++;
                    $right = $this->parseTerm();

                    // Jika operand kanan adalah persentase murni (misal: 100 + 10%),
                    // nilai persentase dihitung relatif terhadap $val (10% dari 100 = 10)
                    if ($right['is_percent']) {
                        $percentAmount = $val * $right['percent_fraction'];
                        if ($op === '+') {
                            $val += $percentAmount;
                        } else {
                            $val -= $percentAmount;
                        }
                    } else {
                        if ($op === '+') {
                            $val += $right['val'];
                        } else {
                            $val -= $right['val'];
                        }
                    }
                } else {
                    break;
                }
            }
            return $val;
        }

        // parseTerm: menangani perkalian (*), pembagian (/), dan persen biner (%)
        private function parseTerm() {
            $left = $this->parseFactor();
            $val = $left['val'];
            $is_percent = $left['is_percent'];
            $percent_fraction = $left['percent_fraction'];

            while ($this->pos < count($this->tokens) && !$this->error) {
                $op = $this->tokens[$this->pos];
                if ($op === '*' || $op === '/') {
                    $this->pos++;
                    $right = $this->parseFactor();
                    if ($op === '*') {
                        $val *= $right['val'];
                    } elseif ($op === '/') {
                        if ($right['val'] == 0) {
                            $this->error = 'Pembagian dengan nol tidak diperbolehkan.';
                            return ['val' => 0, 'is_percent' => false, 'percent_fraction' => 0];
                        }
                        $val /= $right['val'];
                    }
                    $is_percent = false;
                } elseif ($op === '%') {
                    // Kasus jika % ditulis sebagai operator biner: A % B (misal: 100 % 10 -> 10% dari 100 = 10)
                    $this->pos++;
                    if ($this->pos < count($this->tokens) && ($this->tokens[$this->pos] === '(' || is_numeric($this->tokens[$this->pos]) || $this->tokens[$this->pos] === '+' || $this->tokens[$this->pos] === '-')) {
                        $right = $this->parseFactor();
                        $val = $val * ($right['val'] / 100.0);
                        $is_percent = false;
                    } else {
                        $this->pos--;
                        break;
                    }
                } else {
                    break;
                }
            }
            return ['val' => $val, 'is_percent' => $is_percent, 'percent_fraction' => $percent_fraction];
        }

        // parseFactor: menangani tanda unary (+/-) dan postfix %
        private function parseFactor() {
            if ($this->pos >= count($this->tokens)) {
                $this->error = 'Format angka tidak lengkap.';
                return ['val' => 0, 'is_percent' => false, 'percent_fraction' => 0];
            }

            $curr = $this->tokens[$this->pos];
            $sign = 1;
            while ($curr === '+' || $curr === '-') {
                if ($curr === '-') $sign = -$sign;
                $this->pos++;
                if ($this->pos >= count($this->tokens)) {
                    $this->error = 'Format angka tidak lengkap.';
                    return ['val' => 0, 'is_percent' => false, 'percent_fraction' => 0];
                }
                $curr = $this->tokens[$this->pos];
            }

            $primary = $this->parsePrimary();
            $val = $sign * $primary;

            // Cek postfix % (misal: 50%, 10%)
            $is_percent = false;
            $percent_fraction = 0;
            if ($this->pos < count($this->tokens) && $this->tokens[$this->pos] === '%') {
                $nextPos = $this->pos + 1;
                $isBinary = false;
                if ($nextPos < count($this->tokens)) {
                    $nextToken = $this->tokens[$nextPos];
                    if (is_numeric($nextToken) || $nextToken === '(') {
                        $isBinary = true;
                    }
                }

                if (!$isBinary) {
                    $this->pos++;
                    $is_percent = true;
                    $percent_fraction = $val / 100.0;
                    $val = $val / 100.0;
                }
            }

            return ['val' => $val, 'is_percent' => $is_percent, 'percent_fraction' => $percent_fraction];
        }

        private function parsePrimary() {
            if ($this->pos >= count($this->tokens)) {
                $this->error = 'Format angka tidak lengkap.';
                return 0;
            }
            $curr = $this->tokens[$this->pos];
            if (is_numeric($curr)) {
                $this->pos++;
                return (float)$curr;
            }
            if ($curr === '(') {
                $this->pos++;
                $val = $this->parseExpression();
                if ($this->pos >= count($this->tokens) || $this->tokens[$this->pos] !== ')') {
                    $this->error = 'Kurung tutup ")" tidak ditemukan.';
                    return 0;
                }
                $this->pos++;
                return $val;
            }
            $this->error = 'Sintaks tidak valid di dekat: ' . $curr;
            return 0;
        }
    }
}

// Inisialisasi Variabel Awal
$hasil = null;
$pesan = '';
$a = null;
$b = null;
$operator = '+';
$ekspresi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ekspresi = trim($_POST['ekspresi'] ?? '');

    // Fallback jika input dikirimkan dalam format $a, $b, dan $operator
    if ($ekspresi === '' && isset($_POST['a'])) {
        $a_raw = trim($_POST['a'] ?? '');
        $b_raw = trim($_POST['b'] ?? '');
        $operator = $_POST['operator'] ?? '+';
        if ($a_raw !== '' && $b_raw !== '') {
            $ekspresi = $a_raw . ' ' . $operator . ' ' . $b_raw;
        } elseif ($a_raw !== '' && $operator === '%') {
            $ekspresi = $a_raw . '%';
        }
    }

    if ($ekspresi === '') {
        $pesan = 'Mohon masukkan angka atau ekspresi perhitungan.';
    } else {
        $parser = new MathParser($ekspresi);
        $res = $parser->evaluate();
        if ($parser->error) {
            $pesan = $parser->error;
        } else {
            $hasil = $res;
            // Sinkronisasi variabel $a, $b, $operator untuk tampilan dan kompatibilitas tugas praktikum
            if (preg_match('/^\s*(-?\d+(?:\.\d+)?)\s*([\+\-\*\/])\s*(-?\d+(?:\.\d+)?%?)\s*$/', $ekspresi, $match)) {
                $a = (float)$match[1];
                $operator = $match[2];
                $b = str_ends_with($match[3], '%') ? (float)rtrim($match[3], '%') . '%' : (float)$match[3];
            } elseif (preg_match('/^\s*(-?\d+(?:\.\d+)?)\s*%\s*(-?\d+(?:\.\d+)?)\s*$/', $ekspresi, $match)) {
                $a = (float)$match[1];
                $operator = '%';
                $b = (float)$match[2];
            } elseif (preg_match('/^\s*(-?\d+(?:\.\d+)?)\s*%\s*$/', $ekspresi, $match)) {
                $a = (float)$match[1];
                $operator = '%';
                $b = null;
            }
        }
    }
}

// Menentukan tampilan layar LCD
$display_sub = '';
$display_main = '0';

if ($pesan !== '') {
    $display_main = 'Error';
    $display_sub = htmlspecialchars($pesan);
} elseif ($hasil !== null) {
    if (is_float($hasil)) {
        $formatted_hasil = (floor($hasil) == $hasil) ? (string)(int)$hasil : rtrim(rtrim(number_format($hasil, 8, '.', ''), '0'), '.');
    } else {
        $formatted_hasil = (string)$hasil;
    }
    $display_main = $formatted_hasil;
    $display_sub_clean = str_replace(['*', '/'], ['×', '÷'], $ekspresi);
    $display_sub = htmlspecialchars($display_sub_clean) . ' =';
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalkulator Klasik - PBW</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background: linear-gradient(135deg, #1e2530 0%, #11151c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            color: #f1f5f9;
        }

        .calc-wrapper {
            width: 100%;
            max-width: 380px;
        }

        /* Badan Kalkulator Klasik */
        .classic-calc {
            background: linear-gradient(180deg, #374151 0%, #1f2937 100%);
            border-radius: 24px;
            padding: 24px 20px 26px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
            border: 4px solid #111827;
            position: relative;
        }

        /* Bagian Atas: Solar Panel & Merk */
        .calc-top-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding: 0 4px;
        }

        .calc-brand {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .calc-brand span {
            color: #38bdf8;
            font-weight: 800;
        }

        .solar-cell {
            background: #2a2015;
            border: 1px solid #453724;
            border-radius: 4px;
            width: 100px;
            height: 24px;
            display: flex;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.7);
        }

        .solar-grid {
            flex: 1;
            border-right: 1px solid #5a4933;
            background: linear-gradient(180deg, rgba(80, 50, 20, 0.4) 0%, rgba(40, 25, 10, 0.8) 100%);
        }

        .solar-grid:last-child {
            border-right: none;
        }

        /* Layar LCD Klasik */
        .calc-screen {
            background-color: #9cb08f;
            border: 3px solid #1f241c;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 20px;
            box-shadow: 
                inset 0 4px 8px rgba(0, 0, 0, 0.35),
                inset 0 1px 2px rgba(0, 0, 0, 0.4),
                0 1px 0 rgba(255, 255, 255, 0.15);
            color: #1a2414;
            text-align: right;
            position: relative;
            overflow: hidden;
        }

        .screen-badges {
            display: flex;
            justify-content: space-between;
            font-family: 'Courier New', monospace;
            font-size: 0.7rem;
            font-weight: bold;
            color: #3a4b32;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .screen-sub {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.95rem;
            color: #2f3e27;
            height: 20px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            letter-spacing: 1px;
        }

        .screen-main {
            font-family: 'Courier New', Courier, monospace;
            font-size: 2.15rem;
            font-weight: 700;
            letter-spacing: 2px;
            line-height: 1.2;
            word-break: break-all;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        /* Keyboard Grid: 4 Kolom x 6 Baris */
        .calc-keypad {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        /* Tombol Klasik Tactile 3D */
        .btn {
            appearance: none;
            border: none;
            outline: none;
            border-radius: 12px;
            font-size: 1.25rem;
            font-weight: 600;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.08s ease;
            user-select: none;
            position: relative;
        }

        /* Tombol Angka */
        .btn-num {
            background: linear-gradient(180deg, #4b5563 0%, #374151 100%);
            color: #f9fafb;
            box-shadow: 0 4px 0 #1f2937, 0 5px 8px rgba(0, 0, 0, 0.4);
        }

        .btn-num:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #1f2937, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Tombol Operator */
        .btn-op {
            background: linear-gradient(180deg, #64748b 0%, #475569 100%);
            color: #ffffff;
            box-shadow: 0 4px 0 #334155, 0 5px 8px rgba(0, 0, 0, 0.4);
            font-size: 1.35rem;
        }

        .btn-op:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #334155, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Tombol Kurung Buka & Tutup */
        .btn-paren {
            background: linear-gradient(180deg, #475569 0%, #334155 100%);
            color: #38bdf8;
            box-shadow: 0 4px 0 #1e293b, 0 5px 8px rgba(0, 0, 0, 0.4);
            font-size: 1.35rem;
            font-weight: 700;
        }

        .btn-paren:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #1e293b, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Tombol Clear (C) */
        .btn-clear {
            background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            box-shadow: 0 4px 0 #991b1b, 0 5px 8px rgba(0, 0, 0, 0.4);
        }

        .btn-clear:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #991b1b, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Tombol DEL */
        .btn-ce {
            background: linear-gradient(180deg, #f97316 0%, #ea580c 100%);
            color: #ffffff;
            box-shadow: 0 4px 0 #9a3412, 0 5px 8px rgba(0, 0, 0, 0.4);
            font-size: 1.1rem;
        }

        .btn-ce:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #9a3412, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Tombol Sama Dengan (=) */
        .btn-equal {
            background: linear-gradient(180deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            box-shadow: 0 4px 0 #047857, 0 5px 8px rgba(0, 0, 0, 0.4);
            font-size: 1.6rem;
        }

        .btn-equal:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 #047857, 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Status & Alert Banner */
        .alert-box {
            margin-top: 16px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            text-align: center;
            font-weight: 500;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.15);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.15);
            border: 1px solid #10b981;
            color: #6ee7b7;
        }

        footer {
            margin-top: 18px;
            font-size: 0.78rem;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="calc-wrapper">
        <!-- Body Kalkulator Klasik -->
        <div class="classic-calc">
            <!-- Bagian Atas: Brand & Panel Surya -->
            <div class="calc-top-panel">
                <div class="calc-brand">CLASSIC <span>PBW-100</span></div>
                <div class="solar-cell" title="Solar Power Cell">
                    <div class="solar-grid"></div>
                    <div class="solar-grid"></div>
                    <div class="solar-grid"></div>
                    <div class="solar-grid"></div>
                </div>
            </div>

            <!-- Layar LCD Klasik -->
            <div class="calc-screen">
                <div class="screen-badges">
                    <span>Kalkulator</span>
                    <span id="operator-indicator"><?= htmlspecialchars($operator ?: '+') ?></span>
                </div>
                <div class="screen-sub" id="screen-sub"><?= $display_sub ?: '&nbsp;' ?></div>
                <div class="screen-main" id="screen-main"><?= htmlspecialchars($display_main) ?></div>
            </div>

            <!-- Form Utama dikirim ke Backend PHP via POST -->
            <form id="calc-form" method="post" action="">
                <!-- Input ekspresi utama dan parameter pendukung untuk PHP -->
                <input type="hidden" name="ekspresi" id="input-ekspresi" value="<?= htmlspecialchars($ekspresi ?? '') ?>">
                <input type="hidden" name="a" id="input-a" value="<?= htmlspecialchars((string)($a ?? '')) ?>">
                <input type="hidden" name="b" id="input-b" value="<?= htmlspecialchars((string)($b ?? '')) ?>">
                <input type="hidden" name="operator" id="input-op" value="<?= htmlspecialchars($operator ?? '+') ?>">

                <!-- Grid Tombol Klasik (4 kolom x 6 baris) -->
                <div class="calc-keypad">
                    <!-- Baris 1: Kontrol & Kurung ( ) -->
                    <button type="button" class="btn btn-clear" onclick="calculator.clearAll()">C</button>
                    <button type="button" class="btn btn-ce" onclick="calculator.backspace()">DEL</button>
                    <button type="button" class="btn btn-paren" onclick="calculator.append('(')">(</button>
                    <button type="button" class="btn btn-paren" onclick="calculator.append(')')">)</button>

                    <!-- Baris 2 -->
                    <button type="button" class="btn btn-num" onclick="calculator.append('7')">7</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('8')">8</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('9')">9</button>
                    <button type="button" class="btn btn-op" onclick="calculator.appendOp('/')">÷</button>

                    <!-- Baris 3 -->
                    <button type="button" class="btn btn-num" onclick="calculator.append('4')">4</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('5')">5</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('6')">6</button>
                    <button type="button" class="btn btn-op" onclick="calculator.appendOp('*')">×</button>

                    <!-- Baris 4 -->
                    <button type="button" class="btn btn-num" onclick="calculator.append('1')">1</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('2')">2</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('3')">3</button>
                    <button type="button" class="btn btn-op" onclick="calculator.appendOp('-')">−</button>

                    <!-- Baris 5 -->
                    <button type="button" class="btn btn-num" onclick="calculator.append('0')">0</button>
                    <button type="button" class="btn btn-num" onclick="calculator.append('.')">.</button>
                    <button type="button" class="btn btn-op" onclick="calculator.appendPercent()">%</button>
                    <button type="button" class="btn btn-op" onclick="calculator.appendOp('+')">+</button>
                    <!-- Baris 6: Tombol Negatif (±) dan Tombol Hitung (=) yang diperlebar -->
                    <button type="button" class="btn btn-num" onclick="calculator.toggleSign()" title="Positif / Negatif">±</button>
                    <button type="button" class="btn btn-equal" style="grid-column: span 3;" onclick="calculator.submitCalculation()">=</button>
                </div>
            </form>

            <?php if ($pesan): ?>
                <div class="alert-box alert-error">
                    ⚠️ <?= htmlspecialchars($pesan) ?>
                </div>
            <?php elseif ($hasil !== null): ?>
                <div class="alert-box alert-success">
                    ✓ Hasil: <?= htmlspecialchars($display_sub_clean) ?> = <?= htmlspecialchars($formatted_hasil) ?>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            Praktikum Pemrograman Berbasis Web &bull; Kalkulator Klasik
        </footer>
    </div>

    <!-- Logika Interaktivitas Layar dan Input Ekspresi Kalkulator Klasik -->
    <script>
        const calculator = {
            expression: '<?= ($hasil !== null) ? (string)$formatted_hasil : ($ekspresi !== "" ? addslashes($ekspresi) : "0") ?>',
            justCalculated: <?= ($hasil !== null) ? 'true' : 'false' ?>,

            screenMain: document.getElementById('screen-main'),
            screenSub: document.getElementById('screen-sub'),
            inputEkspresi: document.getElementById('input-ekspresi'),
            inputA: document.getElementById('input-a'),
            inputB: document.getElementById('input-b'),
            inputOp: document.getElementById('input-op'),
            form: document.getElementById('calc-form'),

            updateDisplay() {
                // Tampilkan simbol perkalian dan pembagian klasik di layar
                let formattedExpr = this.expression
                    .replace(/\*/g, '×')
                    .replace(/\//g, '÷')
                    .replace(/-/g, '−');
                this.screenMain.textContent = formattedExpr || '0';
            },

            append(val) {
                // Jika baru selesai menghitung
                if (this.justCalculated) {
                    if (val === '(' || val === '-' || (val >= '0' && val <= '9') || val === '.') {
                        this.expression = val === '.' ? '0.' : val;
                    } else {
                        this.expression += val;
                    }
                    this.justCalculated = false;
                    this.screenSub.innerHTML = '&nbsp;';
                    this.updateDisplay();
                    return;
                }

                // Jika nilai layar masih 0 awal
                if (this.expression === '0') {
                    if (val === '.') {
                        this.expression = '0.';
                    } else {
                        this.expression = val;
                    }
                } else {
                    this.expression += val;
                }
                this.updateDisplay();
            },

            appendPercent() {
                if (this.justCalculated) {
                    this.justCalculated = false;
                    this.screenSub.innerHTML = '&nbsp;';
                }

                let trimmed = this.expression.trim();

                // Jika masih kosong atau 0, tidak perlu menambahkan persen
                if (trimmed === '' || trimmed === '0') {
                    return;
                }

                const lastChar = trimmed.slice(-1);

                // Jangan tambahkan % jika karakter terakhir operator atau titik
                if (['%', '+', '-', '*', '/', '.'].includes(lastChar)) {
                    return;
                }

                // Tambahkan tanda % langsung setelah angka atau kurung tutup
                this.expression = trimmed + '%';
                const opIndicator = document.getElementById('operator-indicator');
                if (opIndicator) opIndicator.textContent = '%';
                this.updateDisplay();
            },

            appendOp(op) {
                if (this.justCalculated) {
                    this.justCalculated = false;
                    this.screenSub.innerHTML = '&nbsp;';
                }

                // Jika layar masih 0 dan pengguna menekan tombol minus (-)
                if (this.expression === '0' && op === '-') {
                    this.expression = '-';
                    this.updateDisplay();
                    return;
                }

                const trimmed = this.expression.trim();
                const lastChar = trimmed.slice(-1);

                // Jika karakter terakhir operator +, -, *, / dan ditekan minus
                if (['+', '-', '*', '/'].includes(lastChar) && op === '-') {
                    this.expression = trimmed + ' -';
                    this.updateDisplay();
                    return;
                }

                // Jika karakter terakhir operator +, -, *, / dan ingin diganti operator lain
                if (['+', '-', '*', '/'].includes(lastChar)) {
                    this.expression = trimmed.slice(0, -1).trim() + ' ' + op + ' ';
                    const opIndicator = document.getElementById('operator-indicator');
                    if (opIndicator) opIndicator.textContent = op;
                    this.updateDisplay();
                    return;
                }

                this.expression = trimmed + ' ' + op + ' ';
                const opIndicator = document.getElementById('operator-indicator');
                if (opIndicator) opIndicator.textContent = op;
                this.updateDisplay();
            },

            toggleSign() {
                if (this.justCalculated) {
                    this.justCalculated = false;
                    this.screenSub.innerHTML = '&nbsp;';
                }

                if (this.expression === '0') {
                    this.expression = '-';
                    this.updateDisplay();
                    return;
                }

                if (this.expression === '-') {
                    this.expression = '0';
                    this.updateDisplay();
                    return;
                }

                // Cek angka terakhir dalam ekspresi (termasuk suffix %) untuk di-toggle tandanya
                const match = this.expression.match(/(-?\d+(?:\.\d+)?%?)$/);
                if (match) {
                    const num = match[1];
                    let toggled = '';
                    if (num.startsWith('-')) {
                        toggled = num.substring(1);
                    } else {
                        toggled = '-' + num;
                    }
                    this.expression = this.expression.slice(0, -num.length) + toggled;
                } else {
                    this.expression += '-';
                }
                this.updateDisplay();
            },

            backspace() {
                if (this.justCalculated) {
                    this.clearAll();
                    return;
                }

                let trimmed = this.expression.trimEnd();
                if (trimmed.length <= 1 || (trimmed.length === 2 && trimmed.startsWith('-'))) {
                    this.expression = '0';
                } else {
                    this.expression = trimmed.slice(0, -1).trimEnd();
                    if (this.expression === '') {
                        this.expression = '0';
                    }
                }
                this.updateDisplay();
            },

            clearAll() {
                this.expression = '0';
                this.justCalculated = false;
                this.screenSub.innerHTML = '&nbsp;';
                this.inputEkspresi.value = '';
                this.inputA.value = '';
                this.inputB.value = '';
                this.inputOp.value = '+';
                const opIndicator = document.getElementById('operator-indicator');
                if (opIndicator) opIndicator.textContent = '+';
                this.updateDisplay();
            },

            submitCalculation() {
                const expr = this.expression.trim();
                if (!expr || expr === '0') {
                    return;
                }

                // Set nilai ekspresi ke hidden input
                this.inputEkspresi.value = expr;

                // Ekstrak nilai $a, $b, $operator untuk kompatibilitas tugas praktikum
                const m = expr.match(/^\s*(-?\d+(?:\.\d+)?)\s*([\+\-\*\/])\s*(-?\d+(?:\.\d+)?%?)\s*$/);
                if (m) {
                    this.inputA.value = m[1];
                    this.inputOp.value = m[2];
                    this.inputB.value = m[3];
                } else {
                    const mPercent = expr.match(/^\s*(-?\d+(?:\.\d+)?)\s*%\s*$/);
                    if (mPercent) {
                        this.inputA.value = mPercent[1];
                        this.inputOp.value = '%';
                        this.inputB.value = '';
                    }
                }

                // Kirim form ke PHP Backend
                this.form.submit();
            }
        };

        // Dukungan Keyboard Fisik
        window.addEventListener('keydown', (e) => {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') return;

            if (e.key >= '0' && e.key <= '9') {
                calculator.append(e.key);
            } else if (e.key === '.') {
                calculator.append('.');
            } else if (e.key === '(' || e.key === ')') {
                calculator.append(e.key);
            } else if (e.key === '+') {
                calculator.appendOp('+');
            } else if (e.key === '-') {
                calculator.appendOp('-');
            } else if (e.key === '*' || e.key.toLowerCase() === 'x') {
                calculator.appendOp('*');
            } else if (e.key === '/') {
                calculator.appendOp('/');
            } else if (e.key === '%') {
                calculator.appendPercent();
            } else if (e.key === 'Enter' || e.key === '=') {
                e.preventDefault();
                calculator.submitCalculation();
            } else if (e.key === 'Backspace') {
                calculator.backspace();
            } else if (e.key === 'Escape') {
                calculator.clearAll();
            }
        });
    </script>
</body>

</html>