<!DOCTYPE html>
<html lang="en">
    
	<head>
		<meta charset="utf-8">
		<title>Home</title>
        <link href="./style.css" rel="stylesheet">
		<style>
			table {
			border-collapse: collapse;
			width: 100%;
			}

			table td, table th {
			border: 1px solid #ddd;
			padding: 8px 12px;
			}

			table tr:nth-child(even){background-color: #f2f2f2;}

			table tr:hover {background-color: #ddd;}

			table th {
			padding-top: 8px;
			padding-bottom: 8px;
			text-align: left;
			background-color: #4CAF50;
			color: white;
			}
			.game {
				width:25%;
			}
			.best {
				width:25%;
			}
		</style>
	</head>
	<body>
		<?php NavBar("main",1) ?>
        <main>
			<h1>Welcome</h1>
			<br>
			<h2>Leader Board</h2>
			<table><tbody>
			<tr>
				<th class="game">Game</th><th>Name</th><th>Result</th>
			</tr>
			<tr>
			<td><b>Guess Game</b></td>
			<?php $result=explode(':',$_SESSION['stats']->overall['guessGame']) ?>
			<td><?php echo($result[0]);?></td>
			<td><?php $j=count($result)>1?1:0;
						echo($result[$j]);
				?>
			</td>
			</tr>
			<tr>
			<td><b>Fifteen Puzzle</b></td>
			<?php $result=explode(':',$_SESSION['stats']->overall['fifteenPuzzle']) ?>
			<td><?php echo($result[0]);?></td>
			<td><?php $j=count($result)>1?1:0;
						echo($result[$j]);
				?>
			</td>
			</tr>
			<tr>
			<td><b>Peg Solitaire</b></td>
			<?php $result=explode(':',$_SESSION['stats']->overall['pegSolitaire']) ?>
			<td><?php echo($result[0]);?></td>
			<td><?php $j=count($result)>1?1:0;
						echo($result[$j]);
				?>
			</td>
			</tr>
			<tr>
			<td><b>Mastermind</b></td>
			<?php $result=explode(':',$_SESSION['stats']->overall['mastermind']) ?>
			<td><?php echo($result[0]);?></td>
			<td><?php $j=count($result)>1?1:0;
						echo($result[$j]);
				?>
			</td>
			</tr>
			</tbody></table>

			<h2>Personal Bests</h2>
			<table><tbody>
			<tr>
				<th class="game">Game</th><th class='best'>Best</th><th class='best'>2nd Best</th><th class='best'>3rd Best</th>
			</tr>
			<tr>
			<td><b>Guess Game</b></td>
			<?php for ($x = 0; $x < 3; $x++) {
				echo("<td>". $_SESSION['stats']->PB_guessGame[$x]."</td>");
				} ?>
			</tr>
			<tr>
			<td><b>Fifteen Puzzle</b></td>
			<?php for ($x = 0; $x < 3; $x++) {
				echo("<td>". $_SESSION['stats']->PB_fifteenPuzzle[$x]."</td>");
				} ?>
			</tr>
			<tr>
			<td><b>Peg Solitaire</b></td>
			<?php for ($x = 0; $x < 3; $x++) {
				echo("<td>". $_SESSION['stats']->PB_pegSolitaire[$x]."</td>");
				} ?>
			</tr>
			<tr>
			<td><b>Mastermind</b></td>
			<?php for ($x = 0; $x < 3; $x++) {
				echo("<td>". $_SESSION['stats']->PB_mastermind[$x]."</td>");
				} ?>
			</tr>
			</tbody></table>
        </main>
	</body>
	
</html>


