<?php
function getButton($row, $col) {
    $v = $_SESSION['game']->pegs[$row][$col];
    if ($_SESSION['game']->pegs[$row][$col] == 0) { // empty
        $v = "0";
    } else if($_SESSION['game']->pegs[$row][$col] == 1) { // filled
        $v = "1";
    } 
    $index = ($row *7) + $col;

    // if a player has a peg selected, update the visual
    if ($_SESSION['game']->start != NULL) {
        $selected = $_SESSION['game']->indexToCoords($_SESSION['game']->start);
        if ($selected[0] == $row && $selected[1] == $col) {
            $v = "2";
        }
    }  

    echo "<button type='submit' class='token".$v."' name= 'submit' value='".$index."'/>&nbsp</button>";
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Peg Solitaire</title>
        <link href="./style.css" rel="stylesheet">
        <style>
            table {
                border-collapse: collapse;
            }
            tr,td {
                padding:0;
            }
            <?php for ($i=0;$i<3;$i++) { ?>
            <?php echo ".token".$i ?> {
                all:unset;
                width:50px;
                height:50px;
                background: url('./img/peg<?php echo $i?>.jpg') no-repeat center top;
                background-size:100%;
            }
            <?php echo ".token".$i.":hover" ?> {
                opacity: 0.7;
            }
            <?php }?>
            .token2 {
                opacity: 0.7;
            }

        </style>
	</head>
	<body>
    <?php NavBar("pegSolitaire",1) ?>
    <main>
		<h1>Peg Solitaire</h1>
        <form id="cancel" method="GET"></form>
        <form id="submit" method="POST">
            <?php echo "Moves made: ".$_SESSION['game']->moves;?>
            <br>
            <table>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php getButton(0,2);?></td>
                        <td><?php getButton(0,3);?></td>
                        <td><?php getButton(0,4);?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php getButton(1,2);?></td>
                        <td><?php getButton(1,3);?></td>
                        <td><?php getButton(1,4);?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?php getButton(2,0);?></td>
                        <td><?php getButton(2,1);?></td>
                        <td><?php getButton(2,2);?></td>
                        <td><?php getButton(2,3);?></td>
                        <td><?php getButton(2,4);?></td>
                        <td><?php getButton(2,5);?></td>
                        <td><?php getButton(2,6);?></td>
                    </tr>
                    <tr>
                        <td><?php getButton(3,0);?></td>
                        <td><?php getButton(3,1);?></td>
                        <td><?php getButton(3,2);?></td>
                        <td><?php getButton(3,3);?></td>
                        <td><?php getButton(3,4);?></td>
                        <td><?php getButton(3,5);?></td>
                        <td><?php getButton(3,6);?></td>
                    </tr>
                    <tr>
                        <td><?php getButton(4,0);?></td>
                        <td><?php getButton(4,1);?></td>
                        <td><?php getButton(4,2);?></td>
                        <td><?php getButton(4,3);?></td>
                        <td><?php getButton(4,4);?></td>
                        <td><?php getButton(4,5);?></td>
                        <td><?php getButton(4,6);?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php getButton(5,2);?></td>
                        <td><?php getButton(5,3);?></td>
                        <td><?php getButton(5,4);?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php getButton(6,2);?></td>
                        <td><?php getButton(6,3);?></td>
                        <td><?php getButton(6,4);?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <td><button form="submit" type="submit" name="submit" value="reset">reset</button></td>
            <td><button form="cancel" type="submit" name="submit" value="cancel">cancel</button></td>
            <?php echo(page_token()) ?>

        </form>
        <br>
        <?php if($_SESSION['game']->areMovesLeft() == false) {echo "No more moves. There are ". $_SESSION['game']->pegsLeft . " pegs left.";}?>
    </main>
	</body>
</html>


