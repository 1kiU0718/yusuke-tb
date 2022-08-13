<!doctype html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>Mission5-1</title>
    </head>
    <body>
        
        <?php
        

        // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
         //  データベースに接続する変数を定義する
         //  new PDO：PDO接続を呼び出す（接続先データベース名、ユーザ名、パスワード）
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        
        
        //  条件分岐１：新規投稿
        //  名前、コメント、パスワードフォームが空でない、かつ編集番号確認フォームが空でない場合
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["edit_post"]) && !empty($_POST["password_1"])){
        //  バインド変数を定義
        //  フォームから受信した名前を変数に代入
        $name = $_POST["name"];
        //  フォームから受信したコメントを変数に代入
        $comment = $_POST["comment"]; 
        //  日付
        $date = date("Y/m/d H:i:s");
        //  フォームから受信したパスワードを変数に代入
        $password = $_POST["password_1"];
        //  テーブルにデータを入力：INSERT INTO テーブル名 (カラム名1, カラム名2,...) VALUES (値1, 値2,...)
        $sql_1 = $pdo -> prepare("INSERT INTO TABLE_M5 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
        //  bindParam ($パラメータID, $バインドする変数, PDO::PARAM_STR)
        //  PDO::PARAM_STR = 文字列
        $sql_1 -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql_1 -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql_1 -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql_1 -> bindParam(':password', $password, PDO::PARAM_STR);
    
        //  SQL文を実行する
        $sql_1 -> execute();
        
        }elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit_post"]) && empty($_POST["password_3"])){
        //  バインド変数を定義
        //  
        $id = $_POST["edit_post"];
        //  フォームから受信した名前を変数に代入
        $name = $_POST["name"];
        //  フォームから受信したコメントを変数に代入
        $comment = $_POST["comment"]; 
        //  日付
        $date = date("Y/m/d H:i:s");
        //  フォームから受信したパスワードを変数に代入
        $password = $_POST["password_1"];
        //  テーブルにデータを入力：INSERT INTO テーブル名 (カラム名1, カラム名2,...) VALUES (値1, 値2,...)
        $sql_3 = "UPDATE TABLE_M5 SET name = :name, comment = :comment, date = :date, password = :password WHERE id = :id";
        
        $stmt = $pdo->prepare($sql_3);
        //  bindParam ($パラメータID, $バインドする変数, PDO::PARAM_STR)
        //  PDO::PARAM_STR = 文字列
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
        $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
    
        //  SQL文を実行する
        $stmt -> execute();    
        }
        
        
        
        //  投稿削除
        //  削除対象番号、パスワードフォームが空でない場合
        if(!empty($_POST["delete"]) && !empty($_POST["password_2"])){
        //　バインド変数を定義
        //  削除するidの変数を定義
        $id = $_POST["delete"];
        //　パスワード
        $password = $_POST["password_2"];
        //  指定したidのレコードを削除する
        $sql_2 = "DELETE FROM TABLE_M5 WHERE id = :id AND password = :password";
        //  実行したいSQLを設定し、変数に代入する
        $stmt = $pdo -> prepare($sql_2);
        //  削除するパラメータの値を設定
        //  id
        $stmt -> bindParam (":id", $id, PDO::PARAM_INT);
        //  password
        $stmt -> bindParam (":password", $password, PDO::PARAM_STR);
        //  SQLを実行する
        $stmt -> execute();
        
        }
        
        
        //  編集表示
        //　編集フォームとパスワードフォームが空でない場合
        if(!empty($_POST["edit"]) && !empty($_POST["password_3"])){
        
        $id = $_POST["edit"];
        $password = $_POST["password_3"];
        
        //  SELECT * FROM テーブル名
        $sql_3 = 'SELECT * FROM TABLE_M5 WHERE id = :id AND password = :password';
        //  命令文：入力したデータレコードを抽出する
        //  実行したいSQL文を設定し、DBに接続する
        $stmt = $pdo -> prepare($sql_3);
        //  表示するパラメータの値を設定
        $stmt -> bindParam (":id", $id, PDO::PARAM_INT);
        //  password
        $stmt -> bindParam (":password", $password, PDO::PARAM_STR);
        $stmt -> execute();
        //  すべての要素を配列として取得し、変数resultsに代入する
        $results = $stmt -> fetchAll();
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        $edit_id = $row['id'];
        $edit_name = $row['name'];
        $edit_comment = $row['comment'];
        $edit_password = $row['password'];
        
            }    
        }
        
        
        ?>
        
        <span style= "font-size: 20px;font-weight:bold;">新規投稿フォーム</span><br>
      
        <form action = "mission5-1.php" method = "POST">
            <!-- 新規投稿  -->
            <!-- 名前 -->
        <p><input type = "text" name = "name" placeholder = "名前" value = "<?php if(!empty($_POST["edit"]) && !empty($_POST["password_3"])){ echo $edit_name;}  ?>" ><br>
            <!-- コメント -->
            <input type = "text" name = "comment" placeholder = "コメント"  value = "<?php if(!empty($_POST["edit"]) && !empty($_POST["password_3"])) {echo $edit_comment; } ?>" ><br>
            <!-- パスワード　-->
            <input type = "text" name = "password_1" placeholder = "パスワード" value = "<?php if(!empty($_POST["edit"]) && !empty($_POST["password_3"])) {echo $edit_password; } ?>" >
            <!-- 送信ボタン　-->
            <input type = "submit" name = "submit1" value = "送信"></p>
            
            <ul>
            <li>名前とコメントを自由に投稿してください。</li>
            <li>パスワードは投稿の削除や編集に必要なので必ず入力してください。 </li>
            </ul>
            
            <hr>
            
            <span style= "font-size: 20px;font-weight:bold;">削除フォーム</span><br>
            <!-- 削除 -->
         <p><input type = "number" name = "delete" placeholder = "削除対象番号"><br>
            <!-- パスワード　-->
            <input type = "text" name = "password_2" placeholder = "パスワード" >
            <!-- 削除ボタン　-->
            <input type = "submit" name = "submit2" value = "削除"></p>
            <p></p>
            削除したい投稿番号とご自身で設定したパスワードを入力し「削除」ボタンを押すと、投稿一覧から投稿が削除されます。
            
            <hr>
            
            <span style= "font-size: 20px;font-weight:bold;">編集番号送信フォーム</span><br>
            
            <!-- 編集 -->
        <p><input type = "number" name = "edit" placeholder = "編集対象番号" ><br>
            <!-- パスワード　-->
            <input type = "text" name = "password_3" placeholder = "パスワード" >
            <!-- 編集ボタン　-->
            <input type = "submit" name = "submit3" value = "編集" >
            <!--　編集番号確認　-->
            <input type = "hidden" name = "edit_post" placeholder = "編集番号確認" value = "<?php if(!empty($_POST["edit"]) && !empty($_POST["password_3"])) {echo $edit_id; } ?>" ></p>
            <p></p>
            編集したい投稿番号とご自身で設定したパスワードを入力し「編集」ボタンを押すと、投稿フォームに前回の内容が表示されます。<br>
        </form>
        
        <hr>
        
        <p></p>
        
        投稿番号　名前　コメント　投稿日時<br>
        <hr>
        
        <?php
         // DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
         //  データベースに接続する変数を定義する
         //  new PDO：PDO接続を呼び出す（接続先データベース名、ユーザ名、パスワード）
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        
        //  SELECT * FROM テーブル名
        $sql = 'SELECT * FROM TABLE_M5';
        //  命令文：入力したデータレコードを抽出する
        //  実行したいSQL文を設定し、DBに接続する
        $stmt = $pdo->query($sql);
        //  すべての要素を配列として取得し、変数resultsに代入する
        $results = $stmt->fetchAll();
        //  変数の中に入っている要素の数分、繰り返し処理する
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'];
        '<br>';
        //  水平線を引く
        echo "<hr>";
        }
        ?>
        
    </body>
</html> 
   
        
