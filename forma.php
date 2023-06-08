<!doctype html>
<html>
	<head>
		<title>Upravljanje knjižnicom</title>
		<meta charset="utf-8" />
		<style>
			body {
				background-color: #D6D6D6;
				font-family: Arial;
				text-align: center;
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
		</style>
	</head>
	<body>
		<main>
			<header>
				<h1><font face="Arial">Upravljanje knjižnicom</h1>
			</header>
			<section>
				<?php
					$conn = new mysqli("localhost","root","","baze podataka 2 - knjiznica");

					// Check connection
					if ($conn->connect_error) {
  						die("Connection failed: " . $conn->connect_error);
					}
					
					$clan_id = $fizicka_knjiga_id = $vrijedi_od = $vrijedi_do = $naziv = "";
					
					$clan_id = strip_tags($_POST["clan_id"]);	
					$fizicka_knjiga_id = strip_tags($_POST["fizicka_knjiga_id"]);
					$vrijedi_od = strip_tags($_POST["vrijedi_od"]);
					$vrijedi_do = strip_tags($_POST["vrijedi_do"]);
					$naziv = strip_tags($_POST["naziv"]);
						
					
					/* u slučaju uspješne validacije unos podataka u bazu */
					if(empty($poruka))
					{
						if(isset($_POST['kreiraj'])) {
							if($clan_id and $fizicka_knjiga_id and $vrijedi_od and $vrijedi_od != ""){
								$upit = "select knjiznica_id, isbn from inventar where fizicka_knjiga_id = $fizicka_knjiga_id";
								$rezultatupita = $conn -> query($upit);
								$row = $rezultatupita -> fetch_assoc();
								$knjiznica_id = $row["knjiznica_id"];
								$isbn = $row["isbn"];
								$unos = "insert into posudba values ($clan_id, $fizicka_knjiga_id, '$vrijedi_od', '$vrijedi_do', $knjiznica_id, $isbn)";
								if ($conn->query($unos) === TRUE) {
								echo "Uspješno kreirana nova posudba!";
								} else {
								echo "Unos neuspješan! Razlog:<br>" . $conn->error;
								}
							}else echo "Potrebno je popuniti sva polja za unos!";
						}
						if(isset($_POST['azuriraj'])) {
							if($clan_id and $vrijedi_do != ""){
								$azur = "update posudba set vrijedi_do='$vrijedi_do' where clan_id=$clan_id";
								if ($conn->query($azur) === TRUE) {
								echo "Uspješno ažuriran rok vraćanja knjige!";
								} else {
								echo "Neuspješno ažuriranje! Razlog:<br>" . $conn->error;
								}
							}else echo "Potrebno je unijeti ID Člana i promijniti datum 'Vrijedi do'!";
						}
						if(isset($_POST['izbrisi'])) {
							if($fizicka_knjiga_id != ""){
								$brisanje = "delete from posudba where fizicka_knjiga_id = $fizicka_knjiga_id";
								if ($conn->query($brisanje) === TRUE) {
								echo "Uspješno izbrisana posudba!";
								} else {
								echo "Brisanje neuspješno! Razlog:<br>" . $conn->error;
								}
							}else echo "Potrebno je unijeti Iventarni broj za brisanje posudbe!";
						}
						if(isset($_POST['provjeri'])) {
							if($naziv != ""){
								$dostupnost = "select i.isbn, i.fizicka_knjiga_id, k.naziv_knjige, s.status_knjige 
								from knjiga k inner join inventar i on k.isbn = i.isbn inner join status s on i.status_id = s.status_id 
								where k.naziv_knjige like '$naziv%' order by fizicka_knjiga_id";
								$podaci=$conn->query($dostupnost);
								$row = $podaci -> fetch_assoc();
								if ($podaci->num_rows > 0) {
									echo "<h2>Dostupnost knjiga koje sadrže " .$naziv. " u nazivu</h2>"; 
									echo "<table><tr>
										<th text-align: center>ISBN</th><th>Inventarni broj</th><th>Naziv knjige</th><th>Status knjige</th>
										</tr>";
									while($row = $podaci->fetch_assoc()) {
										echo '<tr> 
											<td>'. $row["isbn"].'</td> 
											<td>'. $row["fizicka_knjiga_id"].'</td> 
											<td>'. $row["naziv_knjige"].'</td> 
											<td>'. $row["status_knjige"].'</td>
											</tr>';
									}
									echo "</table>";
								} else {echo "Nema knjige sa tim nazivom!<br>" . $conn->error;}
							}else {echo "Potrebno je unijeti naziv ili dio naziva knjige!";}
						}
					}
					$conn->close();
					?>
			</section>
			<br><br>
			<input type="button" value="Natrag" onclick="location.href='index.php' " class="btn success" />
		</main>
	</body>
</html>