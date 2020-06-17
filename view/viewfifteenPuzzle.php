<?php

function getButton($id) {
    $v = $_SESSION['game']->tiles[$id] ;
    echo "<td><button id='token".$v."' type='submit' name= 'submit' value='".$id."'/>&nbsp</button></td>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Fifteen Puzzle</title>
        <link href="./style.css" rel="stylesheet">
        <style>
            table {
                border-collapse: collapse;
            }
            tr,td {
                padding:0;
            }
            <?php for ($i=0;$i<16;$i++) { ?>
            <?php echo "#token".$i ?> {
                all:unset;
                width:50px;
                height:50px;
                background: transparent url('./img/15_<?php echo $i?>.jpg') no-repeat center top;
                background-size:100%;
            }
            <?php echo "#token".$i.":hover" ?> {
                opacity: 0.7;
            }
            <?php }?>

        

        </style>
	</head>
	<body>
        <?php NavBar("fifteenPuzzle",1) ?>

        <main>
		<h1>Fifteen Puzzle</h1>
        <form id="cancel" method="get"></form>
        <form id="submit" method="POST">
            <?php echo "Number of moves: ".$_SESSION['game']->moves;?>
            <br>
            <table>
                <tbody>
                    <?php
                        $id = 0;
                        for ($i=0;$i<4;$i++) {
                            print('<tr>');
                            for ($j=0;$j<4;$j++) {
                                getButton($id);
                                $id++;
                            }
                            print('</tr>');
                        }
                    ?>
                </tbody>
            </table>
            <br>
            <td><button form="submit" type="submit" name="submit" value="reset">reset</button></td>
            <td><button form="cancel" type="submit" name="submit" value="cancel">cancel</button></td>
            <?php echo(page_token()) ?>
        </form>
        <br>
        <?php if($_SESSION['game']->isWin()) {echo "You won!!!";}?>
        </main>

	</body>
</html>


