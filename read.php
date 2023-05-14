<?PHP
$dsn = 'mysql:dbname=seiunnjyuku;host=localhost;charset=utf8mb4';
$user = 'root';
$password = "";

if (isset($_GET['submit'])) {
    try {
        echo'<script>console.log("submit発見")</script>';
        $pdo = new PDO($dsn, $user, $password);

        // 動的に変わる値をプレースホルダに置き換えたINSERT文をあらかじめ用意する
        $sql_insert = 'SELECT * FROM products WHERE :id';
        $stmt_insert = $pdo->prepare($sql_insert);

        // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
        $stmt_insert->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        
        // SQL文を実行する
        $stmt_insert->execute();

        // 商品一覧ページにリダイレクトさせる
        header("Location: read.php");
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}

try {
    $pdo = new PDO($dsn, $user, $password);
    $sql = 'SELECT * FROM wd';
    $stmt_select = $pdo->query($sql);
    $count = $stmt_select->rowCount();
    $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit($e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <link rel="stylesheet" href="css/styleread.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <nav>
                <a href="index.php">模擬問題アプリ</a>
            </nav>
        </header>
        <main>
            <div class="flex">
                <div class="mainLeft">
                    <h1>模擬問題</h1>
                    <?php
                        echo "<p>問題件数:Total{$count}</p>";
                    ?>
                </div>
                <div class="mainRight">
                    <?php
                        if(!(isset($_GET["id"]))){
                            $keyWordId = "<form action='read.php' method='get'>
                            <label>問題No:<input type='text' name='id' value='{$products[0]["id"]}'></label>
                            <input type='submit' name='submit' value='次の問題へ'>
                            </form>
                            ";
                            echo $keyWordId;
                        }else{
                        }
                    ?>
                        <?php
                            if(!(isset($_GET["id"]))){
                                $keyWord = "
                                    <p>問題: <span>{$products[0]['question_text']}</span></p>
                                    <p>選択肢A: <span>{$products[0]['toi1']}</span></p>
                                    <p>選択肢B: <span>{$products[0]['toi2']}</span></p>
                                    <p>選択肢C: <span>{$products[0]['toi3']}</span></p>
                                    <p>選択肢D: <span>{$products[0]['toi4']}</span></p>
                                    </tr>
                                    ";
                                echo $keyWord;
                            }else{
                                foreach ($products as $product) {
                                    $keyWord = "
                                    <p>問題: <span>{$products[1]['question_text']}</span></p>
                                    <p>選択肢A: <span>{$products[1]['toi1']}</span></p>
                                    <p>選択肢B: <span>{$products[1]['toi2']}</span></p>
                                    <p>選択肢C: <span>{$products[1]['toi3']}</span></p>
                                    <p>選択肢D: <span>{$products[1]['toi4']}</span></p>
                                        ";
                                    echo $keyWord;
                                }
                            }
                        ?>

                </div>
            </div>
        </main>
        <footer>
            <p class="copyright">&copy; 模擬問題アプリ All rights reserved.</p>
        </footer>
    </div>
</body>

</html>