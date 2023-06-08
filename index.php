<!doctype html>
<html>
	<head>
		<title>Upravljanje knjižnicom</title>
		<meta charset="utf-8" />
		<style>
			body {
				background-color: #D6D6D6;
				font-family: Arial;
			}
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			table{
				max-width: 960px; 
				margin: auto;
			}
			th, td {
				padding: 5px;
				text-align: center;
				background-color: white;
			}
			.btn {
				border: 2px solid black;
				background-color: white;
				color: black;
				padding: 10px 19px;
				font-size: 14px;
				cursor: pointer;
			}

			.success {
				border-color: #4CAF50;
				color: green;
			}

			.success:hover {
				background-color: #4CAF50;
				color: white;
			}
			
			.info {
				border-color: #2196F3;
				color: dodgerblue;
				float: right;
			}

			.info:hover {
				background: #2196F3;
				color: white;
				float: right;
			}

			.warning {
				border-color: #ff9800;
				color: orange;
				float: right;
			}

			.warning:hover {
				background: #ff9800;
				color: white;
				float: right;
			}

			.danger {
				border-color: #f44336;
				color: red;
				float: right;
			}

			.danger:hover {
				background: #f44336;
				color: white;
				float: right;
			}

		</style>
	</head>
	<body style="background-color: #D6D6D6">
		<main>
			<header style="text-align: center">
				<h1>Upravljanje knjižnicom</h1>
			</header>
			<section>
				<article style="background-color: white; padding: 20px; width: 290px; max-width: 290px; margin: auto">
					<form action="forma.php" method="post">
						<h3 style="text-align: center; margin-top: 0px">Posudba knjiga</h3>
						ID Člana:<input type="text" name="clan_id" style="float: right; width: 122px; height: 18px"/><br><br>
						Inventarni broj knjige:<input type="text" name="fizicka_knjiga_id" style="float: right; width: 122px; height: 18px" /><br><br>
						Posudba vrijedi od: <input type="date" name="vrijedi_od" style="float: right; width: 125px; height: 20px"/><br><br> 
						Posudba vrijedi do: <input type="date" name="vrijedi_do" style="float: right; width: 125px; height: 20px"/><br><br>
						<input type="submit" name="azuriraj" value="Ažuriraj rok vraćanja" class="btn warning"/><br><br><br>
						<input type="submit" name="kreiraj" value="Kreiraj posudbu" class="btn success"/>
						<input type="submit" name="izbrisi" value="Izbriši posudbu" class="btn danger"/><br><br>
						Provjeri dostupnost prema nazivu knjige: <br><br><input type="text" name="naziv" style="width: 175px; height: 18px; margin: 7px 0" />
						<input type="submit" name="provjeri" value="Provjeri"  class="btn info" />
					</form> 
				</article>
				<article>
					<h2 style ="text-align: center">Prikaz svih posudbi</h2>
						<?php
						
						$conn = new mysqli("localhost","root","","baze podataka 2 - knjiznica");

						// Provjera veze na bazu
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						$sql = "select * from posudba order by fizicka_knjiga_id";
						$result = $conn->query($sql);
						//postavke tablice
						echo "<table><tr>
						<th text-align: center>ID Člana</th><th>Inventarni broj</th><th>Vrijedi od</th><th>Vrijedi do</th><th>Broj knjižnice</th><th>ISBN</th>
						</tr>";
						if ($result->num_rows > 0) {
						// ispis sadrzaja svih redova tablice
							while($row = $result->fetch_assoc()) {
								echo '<tr> 
									<td>'. $row["clan_id"].'</td> 
									<td>'. $row["fizicka_knjiga_id"].'</td> 
									<td>'. $row["vrijedi_od"].'</td> 
									<td>'. $row["vrijedi_do"].'</td>
									<td>'. $row["knjiznica_id"].'</td> 
									<td>'. $row["isbn"].'</td>
									</tr>';
							}
						} else echo "0 results";
						$conn->close();
						?>
				</article>
			</section>
		</main>
	</body>
</html>