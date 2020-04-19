<?php
if(!isset($_GET['id']) || empty($_GET['id'])){
	header('Location:index.php');
	exit;
}


$sorgu = $db -> prepare(' SELECT * FROM yoneticiler WHERE id = ? ');
$sorgu -> execute( [$_GET['id']] );
$ogretmen = $sorgu -> fetch(PDO::FETCH_ASSOC);

if (!$ogretmen) {
	header('Location:index.php?sayfa=ogr_update');
	exit;
}



if(isset($_POST['submit'])){
	if(isset($_POST['submit'])){

		$isim 		= isset($_POST['isim']) 	 ? $_POST['isim'] 		: $ogretmen['ad'];
		$soyisim 	= isset($_POST['soyisim']) 	 ? $_POST['soyisim']	: $ogretmen['soyad'];
		$tcno		= isset($_POST['tcno']) 	 ? $_POST['tcno'] 		: $ogretmen['tcno'];
		$kadi		= isset($_POST['kadi']) 	 ? $_POST['kadi'] 		: $ogretmen['username'];
		$sifre		= isset($_POST['sifre']) 	 ? $_POST['sifre'] 		: $ogretmen['sifre'];
		$telno 		= isset($_POST['telno']) 	 ? $_POST['telno'] 		: $ogretmen['telefon'];
		$email 		= isset($_POST['email']) 	 ? $_POST['email'] 		: $ogretmen['eposta'];	
		$hata 		= '';

		if(!$isim){

			#isim boşmu
			$hata.= 'İsim alanı boş bırakılamaz<br>';

		}else if(!$soyisim){

			#soyisim boşmu
			$hata.= 'Soyisim alanı boş bırakılamaz<br>';

		}else if(!$tcno){

			# tcno boşmu
			$hata.= 'Tcno alanı boş bırakılamaz<br>';

		}else if(!ctype_digit($tcno)){

			# tcno sayısal değermi
			$hata.= 'Tcno alanı sayısal değer olmalıdır<br>';

		}else if (!(strlen($tcno) == 11)) {

			# tcno 11 haneden mi oluşuyor?
			$hata.= 'Tcno alanı 11 haneden oluşmalıdır<br>';

		}else if(!$kadi){

			# tcno boşmu
			$hata.= 'Kullanıcı adı alanı boş bırakılamaz<br>';

		 }else if(!$sifre){

			# tcno boşmu
			$hata.= 'Şifre alanı boş bırakılamaz<br>';

		 }else if(!$telno){

			# tcno boşmu
			$hata.= 'Telefon numarası alanı boş bırakılamaz<br>';

		 }else if(!ctype_digit($telno)){

			# telno sayısal değermi
			$hata.= 'Telefon numarası alanı sayısal değer olmalıdır<br>';

		}else if (!(strlen($telno) == 10)) {

			# telno 10 haneden mi oluşuyor?
			$hata.= 'Telefon numarası alanı 10 haneden oluşmalıdır, lütfen 0 olmadan boşluksuz 10 haneli değer girin<br>';

		}else if(!$email){

			# tcno boşmu
			$hata.= 'Email alanı boş bırakılamaz<br>';

		}else{

			# güncelleme işlemi
			$sorgu = $db -> prepare('UPDATE yoneticiler SET
				ad 			= ?,
				soyad 		= ?,
				tcno 		= ?,
				username 	= ?,
				sifre 		= ?,
				telefon 	= ?,
				eposta 		= ?
				WHERE id 	= ?'
			);

			$guncelle = $sorgu -> execute([
				$isim,
				$soyisim,
				$tcno,
				$kadi,
				$sifre,
				$telno,
				$email,
				$_GET['id']
			]);

			if ($guncelle) {
				header('Location:index.php?sayfa=ogr_update&guncelleme-is=true');
			}else{
				echo 'güncelleme işlemi başarısız...';
			}
		}	
	}
}


?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">
						Öğretmen Güncelle
					</h6>
				</div>
				<div class="card-body">

					<form action="" method="post">

						<!-- formdan gelen hata varsa -->
						<?php if (@$hata && $hata != ''): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  						<strong>Hata!</strong> <?php echo $hata; ?>
	  						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    						<span aria-hidden="true">&times;</span>
	  						</button>
						</div>
						<hr>
						<?php endif; ?>	

						<div class="form-group">
						    <label for="isim">İsim</label>
						    <input type="text" required="" name="isim"  class="form-control" id="isim" placeholder="İsim" value="<?php echo isset($_POST['isim']) ? $_POST['isim'] : $ogretmen['ad']?>">
						    
					  	</div>
					 	<div class="form-group">
					    	<label for="soyisim">Soyisim</label>
					    	<input type="text" required="" name="soyisim"  class="form-control" id="soyisim" placeholder="Soyisim" 
					    	value="<?php echo isset($_POST['soyisim']) ? $_POST['soyisim'] : $ogretmen['soyad']?>"
					    	>
					  	</div>
					  	<div class="form-group">
					    	<label for="tckimlik">Tc. Kimlik No</label>
					    	<input type="text" required="" name="tcno"  class="form-control" id="tckimlik" placeholder="11 haneli tc kimlik no" maxlength="11" 
					    	value="<?php echo isset($_POST['tcno']) ? $_POST['tcno'] : $ogretmen['tcno']?>"
					    	>
					  	</div>
					  	<div class="form-group">
					    	<label for="kadi">Kullanıcı Adı</label>
					    	<input type="text" required="" name="kadi"  class="form-control" id="kadi" placeholder="Kullanıcı Adı" 
							value="<?php echo isset($_POST['kadi']) ? $_POST['kadi'] : $ogretmen['username']?>"
					    	>
					  	</div>
					  	<div class="form-group">
					    	<label for="sifre">Şifre</label>
					    	<input type="text" required="" name="sifre"  class="form-control" id="sifre" placeholder="Şifre" value="<?php echo isset($_POST['sifre']) ? $_POST['sifre'] : $ogretmen['sifre']?>"
					    	>
					  	</div>
					  	<div class="form-group">
					    	<label for="tel">Telefon No</label>
					    	<input type="text" required="" name="telno"  class="form-control" id="tel" placeholder="5XX XXX XX XX (10 haneli boşluksuz yazınız)" maxlength="10" 
							value="<?php echo isset($_POST['telno']) ? $_POST['telno'] : $ogretmen['telefon']?>"
					    	>
					  	</div>
					  	<div class="form-group">
					    	<label for="mail">Email</label>
					    	<input type="email" required="" name="email"  class="form-control" id="mail" placeholder="Email" 
							value="<?php echo isset($_POST['email']) ? $_POST['email'] : $ogretmen['eposta']?>"
					    	>
					  	</div>									
					  	<div>
					  		<input type="hidden" name="submit" value="1">
					  	</div>	
					  	<div class="form-group">
							<button type="submit" class="btn btn-danger form-control">Güncelle</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>