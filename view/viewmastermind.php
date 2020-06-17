<?php

function getGuess($id) {
    $v = $_SESSION['game']->guesses[$id] ;
    if ($_SESSION['game']->guesses[$id] === NULL) {
        $v = "x";
    } 
    echo "<button type='submit' class='token token".$v."' value='".$id." disable'/>&nbsp</button>";
}

function getHint($id) {
    $v = $_SESSION['game']->hint[$id] ;
    if ($_SESSION['game']->hint[$id] === NULL) {
        $v = "x";
    } 
    echo "<button type='submit' class='hint hint".$v."'  value='".$id." disable'/>".$v."</button>";
}
function getRow($row) {
    print('<tr>');
    for ($i=0;$i<4;$i++){
        print('<td>');
        getGuess($row*4+$i);
        print('</td>');
    }
    print('<td><table class="hints">');
    for ($j=0;$j<2;$j=$j+1) {
        print('<tr><td>');
        getHint($row*4+$j*2);
        print('</td><td>');
        getHint($row*4+$j*2+1);
        print('</td></tr>');
    } 
    print("</table></td>");
    print('</tr>');
}

function getSol($id) {
    if ($_SESSION['game']->isGameOver()) {
        $v = $_SESSION['game']->solution[$id] ;
    } else {
        $v = 'x';
    }
    
    echo "<button type='submit' class='token".$v."'  name= value='".$id." disable'/>&nbsp</button>";
}
function getButton($id) {
    $disabled = '';
    if ($_SESSION['game']->isCheck()) {
        $disabled = 'disabled';
    }
    echo "<button type='submit' class='control token".$id."'  name= 'submit' value='".$id."' ".$disabled."/>&nbsp</button>";
}


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <title>Mastermind</title>
        <link href="./style.css" rel="stylesheet">
        <style>
            .hints {
                width:40px;
                height:40px;
                font-size:2px;
            }
 
            table {
                border-collapse: collapse;
            }
            tr,td {
                padding:0;
            }
            #solution {
                float:left;
                padding-left:3%;
            }
            #panel {
                float:left;
                padding-left:10%;
                padding-right:3%;
                height:100%;
            
            }
            #board {
                float:left;
                display: table;
                table-layout: fixed;
                
            }


            <?php for ($i=0;$i<6;$i++) { ?>
            <?php echo ".token".$i ?> {
                all:unset;
                width:40px;
                height:40px;
                background: transparent url('./img/mm<?php echo $i?>.jpg') no-repeat center top;
                background-size:100%;
                padding:0;
                margin:0;
            }
            <?php echo ".token".$i.":hover" ?> {
                opacity: 0.7;
            }
            <?php }?>
            .tokenx {
                all:unset;
                width:40px;
                height:40px;
                background: transparent url('./img/mmx.jpg') no-repeat center top;
                background-size:100%;
            }
            .hintx {
                all:unset;
                width:20px;
                height:20px;
                background: transparent url('./img/mmx.jpg') no-repeat center top;
                background-size:100%;
            }
            .hint2 {
                all:unset;
                width:20px;
                height:20px;
                background: transparent url('./img/mmw.jpg') no-repeat center top;
                background-size:100%;
            }
            .hint1 {
                all:unset;
                width:20px;
                height:20px;
                background: transparent url('./img/mmb.jpg') no-repeat center top;
                background-size:100%;
            }


        </style>

	</head>
	<body>
        <?php NavBar("mastermind",1) ?>
        <main>
        <h1>Mastermind</h1>
        </main>
        <form id="cancel" method="GET"></form>
        <div id="panel">
            Panel
            <form id="submit" method="POST">
                <?php for($i = 0; $i<6;$i++){
                            getButton($i); 
                    } ?>
                <br>
                <?php $disabled="disabled";
                if($_SESSION['game']->isCheck()) {
                    $disabled="";
                }
                ?>
                <table>
                <tbody>
                    <tr>
                        <td>
                            <input type="submit" class='button' name="submit" value="check" <?php echo $disabled?>/>
                        </td>
                        <td>
                            <input type="submit" class='button' name="submit" value="delete" />
                        </td>
                    </tr>
                    <tr>
                    <td>
                    <button form="submit" type="submit" name="submit" value="reset">reset</button>
            </td>
            <td>
            <button form="cancel" type="submit" name="submit" value="cancel">cancel</button>
            </td>
            </tr>
            </tbody>
            </table>    
                <?php echo(page_token()) ?>
            </form>
        </div>
        <div id='board'>
            <?php echo "Number of rounds: ".$_SESSION['game']->moves;?>
            <br>
      
            <table>
                <tbody>
                    <?php
                        for ($row=0;$row<10;$row++) {
                            getRow($row);
                        }
                    ?>
                </tbody>
            </table>
        </div>
		<div id='solution'>
            Solution
			<table>
                <tbody>
                    <tr>
                        <td><?php getSol(0) ;?></td>
                        <td><?php getSol(1) ;?></td>
                        <td><?php getSol(2) ;?></td>
                        <td><?php getSol(3) ;?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <?php 
                if($_SESSION['game']->isGameOver()){
                    if ($_SESSION['game']->isWin()){
                        echo "You won!!!";
                    } else {
                        echo "You lost!!!";
                    }
                    
                    
                }?>
        </div>
      
	</body>
</html>


