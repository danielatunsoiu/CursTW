<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exerciții PHP - Introducere</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .exercises-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .exercise-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .exercise-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .exercise-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.4rem;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }

        .exercise-card p {
            margin-bottom: 15px;
            color: #555;
        }

        .code-block {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
            border-left: 4px solid #667eea;
        }

        .output {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #48bb78;
        }

        .output h4 {
            color: #2d3748;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .btn:hover {
            background: #5a6fd8;
        }

        .theory-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .theory-section h2 {
            color: #667eea;
            margin-bottom: 20px;
            text-align: center;
        }

        .tip {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 8px 8px 0;
        }

        footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            padding: 20px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .exercises-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1> Exerciții PHP - Introducere</h1>
        </header>

        <div class="theory-section">
            <h2> Ce este PHP?</h2>
            <p>PHP este un limbaj de programare server-side folosit pentru crearea paginilor web dinamice.</p>
            <div class="tip">
                <strong> Tip:</strong> PHP rulează pe server, iar rezultatul este trimis browser-ului ca HTML simplu.
            </div>
        </div>

        <div class="exercises-grid">
            <!-- Exercițiul 1 -->
            <div class="exercise-card">
                <h3>1. Variabile și Afișare</h3>
                <p>Declară variabile și afișează-le valorile</p>
                <div class="code-block">
                    &lt;?php<br>
                    $nume = "Alex";<br>
                    $varsta = 25;<br>
                    $inaltime = 1.75;<br>
                    <br>
                    echo "Nume: " . $nume . "&lt;br&gt;";<br>
                    echo "Vârsta: $varsta ani&lt;br&gt;";<br>
                    echo "Înălțime: $inaltime m";<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    $nume = "Dana";
                    $varsta = 25;
                    $inaltime = 1.75;
                    
                    echo "Nume: " . $nume . "<br>";
                    echo "Vârsta: $varsta ani<br>";
                    echo "Înălțime: $inaltime m";
                    ?>
                </div>
            </div>

            <!-- Exercițiul 2 -->
            <div class="exercise-card">
                <h3>2. Operații Matematice</h3>
                <p>Efectuează operații matematice de bază</p>
                <div class="code-block">
                    &lt;?php<br>
                    $a = 15;<br>
                    $b = 4;<br>
                    <br>
                    $suma = $a + $b;<br>
                    $diferenta = $a - $b;<br>
                    $produs = $a * $b;<br>
                    $cat = $a / $b;<br>
                    $rest = $a % $b;<br>
                    <br>
                    echo "Suma: $suma&lt;br&gt;";<br>
                    echo "Diferența: $diferenta&lt;br&gt;";<br>
                    echo "Produs: $produs&lt;br&gt;";<br>
                    echo "Cat: $cat&lt;br&gt;";<br>
                    echo "Rest: $rest";<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    $a = 15;
                    $b = 4;
                    
                    $suma = $a + $b;
                    $diferenta = $a - $b;
                    $produs = $a * $b;
                    $cat = $a / $b;
                    $rest = $a % $b;
                    
                    echo "Suma: $suma<br>";
                    echo "Diferența: $diferenta<br>";
                    echo "Produs: $produs<br>";
                    echo "Cat: $cat<br>";
                    echo "Rest: $rest";
                    ?>
                </div>
            </div>

            <!-- Exercițiul 3 -->
            <div class="exercise-card">
                <h3>3. Structuri de Control - IF</h3>
                <p>Verifică dacă un număr este par sau impar</p>
                <div class="code-block">
                    &lt;?php<br>
                    $numar = 7;<br>
                    <br>
                    if ($numar % 2 == 0) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;echo "$numar este par";<br>
                    } else {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;echo "$numar este impar";<br>
                    }<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    $numar = 7;
                    
                    if ($numar % 2 == 0) {
                        echo "$numar este par";
                    } else {
                        echo "$numar este impar";
                    }
                    ?>
                </div>
            </div>

            <!-- Exercițiul 4 -->
            <div class="exercise-card">
                <h3>4. Bucle - FOR</h3>
                <p>Afișează numerele de la 1 la 10</p>
                <div class="code-block">
                    &lt;?php<br>
                    for ($i = 1; $i <= 10; $i++) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;echo "$i ";<br>
                    }<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "$i ";
                    }
                    ?>
                </div>
            </div>

            <!-- Exercițiul 5 -->
            <div class="exercise-card">
                <h3>5. Array-uri</h3>
                <p>Lucrează cu array-uri și folosește bucla foreach</p>
                <div class="code-block">
                    &lt;?php<br>
                    $fructe = array("Măr", "Banana", "Portocală", "Struguri");<br>
                    <br>
                    echo "Lista fructe:&lt;br&gt;";<br>
                    foreach ($fructe as $fruct) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;echo "- $fruct&lt;br&gt;";<br>
                    }<br>
                    <br>
                    echo "&lt;br&gt;Număr total fructe: " . count($fructe);<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    $fructe = array("Măr", "Banana", "Portocală", "Struguri");
                    
                    echo "Lista fructe:<br>";
                    foreach ($fructe as $fruct) {
                        echo "- $fruct<br>";
                    }
                    
                    echo "<br>Număr total fructe: " . count($fructe);
                    ?>
                </div>
            </div>

            <!-- Exercițiul 6 -->
            <div class="exercise-card">
                <h3>6. Funcții</h3>
                <p>Crează și folosește funcții personalizate</p>
                <div class="code-block">
                    &lt;?php<br>
                    function salut($nume) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;return "Bună, $nume! Ce mai faci?";<br>
                    }<br>
                    <br>
                    function patrat($x) {<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;return $x * $x;<br>
                    }<br>
                    <br>
                    echo salut("Maria") . "&lt;br&gt;";<br>
                    echo "Patratul lui 5 este: " . patrat(5);<br>
                    ?&gt;
                </div>
                <div class="output">
                    <h4>Rezultat:</h4>
                    <?php
                    function salut($nume) {
                        return "Bună, $nume! Ce mai faci?";
                    }
                    
                    function patrat($x) {
                        return $x * $x;
                    }
                    
                    echo salut("Maria") . "<br>";
                    echo "Patratul lui 5 este: " . patrat(5);
                    ?>
                </div>
            </div>
        </div>

        <div class="theory-section">
            <h2>🎯 Exerciții Practice - Încearcă Singur!</h2>
            <div class="exercises-grid">
                <div class="exercise-card">
                    <h3>Exercițiul 1: Calculator Vârstă</h3>
                    <p>Scrie un script care calculează vârsta unei persoane în ani, luni și zile.</p>
                    <a href="#" class="btn">Încearcă soluția</a>
                </div>

                <div class="exercise-card">
                    <h3>Exercițiul 2: Numere Prime</h3>
                    <p>Verifică dacă un număr este prim folosind PHP.</p>
                    <a href="#" class="btn">Încearcă soluția</a>
                </div>

                <div class="exercise-card">
                    <h3>Exercițiul 3: Calculator BMI</h3>
                    <p>Calculează Indicele de Masă Corporală (BMI) pe baza greutății și înălțimii.</p>
                    <a href="#" class="btn">Încearcă soluția</a>
                </div>
            </div>
        </div>

        <footer>
            <p>🎓 Continuă să exersezi! Practice makes perfect.</p>
        </footer>
    </div>
</body>
</html>