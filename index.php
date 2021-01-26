<?php
    include('./lib/xor.php');
    include('./lib/captcha.php');
    $myfile = fopen("./content/log.x", "a");
    $data = $_SERVER['REMOTE_ADDR'];
    $data .= " => ";
    $_SERVER['HTTP_USER_AGENT'] = preg_replace("/>/i", "", $_SERVER['HTTP_USER_AGENT']);
    $_SERVER['HTTP_USER_AGENT'] = preg_replace("/</i", "", $_SERVER['HTTP_USER_AGENT']);
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= "<br /><hr /><br />";
    fwrite($myfile, xor_this($data));
    fclose($myfile);
    if(array_key_exists("s", $_POST)){
        #echo "<script>alert(\"متاسفانه فعلا این قابلیت به صورت ازاد نیست\")</script>";
        if(!array_key_exists("ok", $_POST)){
            if(!array_key_exists("select", $_POST)){
                ?>
                    <html>
                        <body>
                            <form action="" method="POST">
                                <input type="radio" id="c" name="select" text="create" value="create" />
                                <label for="c">Create</label>
                                <input type="radio" id="d" name="select" value="dump" />
                                <input type="hidden" name="s" />
                                <label for="d">Dump</label>
                                <input type="submit" name="submit" value="image" />
                            </form>
                        </body>
                    </html>
                <?php
            }else{
                if($_POST['select'] === "create"){
                    ?>
                        <html>
                            <body>
                                <form action="" method="POST">
                                    <br /><h1>Image</h1><hr />
                                    <textarea name="data" rows="5" cols="20"></textarea><br />
                                    <input type="text" name="pass" placeholder="password(if encode): " />
                                    <input type="text" name="found" placeholder="found: " />
                                    <input id="t" type="checkbox" name="e" />
                                    <input type="hidden" name="s" />
                                    <label for="t">encode</label>
                                    <input type="hidden" name="ok" /><br />
                                    <input type="hidden" name="select" value="create" /><br />
                                    <input type="submit" name="submit" value="image" />
                                </form>
                            </body>
                        </html>
                    <?php
                }else if($_POST['select'] === "dump"){
                    ?>
                        <html>
                            <body>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="upload_image" />
                                    <input type="hidden" name="select" value="dump" />
                                    <input type="hidden" name="ok" />
                                    <input id="c" type="checkbox" name="e" />
                                    <input type="hidden" name="s" />
                                    <label for="c">encode</label>
                                    <input type="text" name="pass" placeholder="password(if encode):" />
                                    <input type="text" name="found" placeholder="found:" />
                                    <input type="submit" name="submit" value="image" />
                                </form>
                            </body>
                        </html>
                    <?php
                }else{
                    echo "error in image";
                }
            }
        }else{
            if($_POST['select'] === "create"){
            $myimage = fopen("./content/image.jpg", "r");
            $data = fread($myimage, filesize("./content/image.jpg"));
            fclose($myimage);
            $name = randomStr() . ".jpg";
            if (array_key_exists("e", $_POST)){
                if(isset($_POST['pass'])){
                    $data = $data . $_POST['found'] . xor_this($_POST['data'], $_POST['pass']);
                }else{
                    die("error");
                }
            }else{
                $data = $data . $_POST['found'] . $_POST['data'];
            }
            $myimage = fopen("./content/image/$name" , "w");
            fwrite($myimage, $data);
            fclose($myimage);
            echo "<img src=\"./content/image/$name\"  />";
            echo "file is <a href=\"./content/image/$name\">file<a>";
        }else if($_POST['select'] === "dump"){
            $file = $_FILES['upload_image'];
            $myfile = fopen($file['tmp_name'] ,"r");
            $data = fread($myfile, filesize($file['tmp_name']));
            fclose($myfile);
            $found = $_POST['found'];
            #$data = preg_replace("/.*$found/", "", $data);
            $data = preg_split("/.*$found/", $data);
            if(array_key_exists("e", $_POST)){
                $data[1] = xor_this($data[1], $_POST['pass']);
            }
            echo "<textarea rows=\"10\" cols=\"20\">$data[1]</textarea>";
        }else{
            echo "<h2>error</h2>";
        }}
    }else{
        ?>
        <html>
            <head>
                <meta charset="UTF-8" />
            </head>
            <body style="direction: rtl;">
                <h1>تبدیل متن به عکس</h1><hr />
                <p>شما می توانید با استفاده از این قابلیت متن های خود را تبدیل به عکس کنید<br /></p>
                <h3>راهنما</h3><br />
                <h5>تبدیل متن به عکس</h5><br />
                <ol>
                    <li>متن خود را وارد کنید</li>
                    <li>درصورتی که می خواهید دیتا را رمز کنید تیک گزینه encode را بزنید</li>
                    <li>اگر تیک گزینه encode را زدید باید یک پسورد هم بدهید</li>
                    <li>سپس found را بدهید </li>
                </ol> 
                <p>توجه برای بازیابی متن نیاز به پسورد و found است</p>
                <h5>تبدیل عکس به متن</h5><br />
                <ol>
                    <li>عکس خود را وارد کنید</li>
                    <li>درصورتی که دیتا  رمز است تیک گزینه encode را بزنید</li>
                    <li>اگر تیک گزینه encode را زدید باید یک پسورد هم بدهید</li>
                    <li>سپس found را بدهید </li>
                </ol>
                <form action="" method="POST"><input type="submit" name="s" value="باز کردن پنل" /></form> 
            </body>
        </html>
        <?php
    }
?>#sdf

