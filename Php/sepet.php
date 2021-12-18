<?php


ob_start();
header('content-type: text/html; charset=utf8');


?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Alışveriş Sepeti Projem</title>
</head>
<body>

<?php

$baglanti = mysqli_connect("localhost","root","root1","sepet") or die ("Veritabanı bağlantısı sağlanamadı.".mysql_error());
$sonuc = mysqli_query($baglanti,"select * from alisveris_sepetim");

$oku = mysqli_fetch_object($sonuc);
/*if(mysqli_num_rows($sonuc)!=0)
{
    while($oku = mysqli_fetch_object($sonuc))
    {
        echo "Kitap adi:".$oku->UrunAdi." <br>Kitap ISBN: ".$oku->Fiyati."<br><br>";
        //echo $.oku->yazari; //bu satir hatalidir cunku sql sorgumuzda yazari alanini secmedik
    }
}else{
    echo "Hic kayit yok!";
	return;
}*/

	/*foreach ( $sonuc as $sonuc1 ){
	echo 'Sepetinizde  <strong>'.$sonuc1.' adet </strong> ürün bulunmaktadır. <a href="?tumurunler=true">[Listeye Geri Dön]</a> ';
		
	}*/


	function guvenlik($par){
		return htmlspecialchars(trim($par));
	}
	array_map('guvenlik', $_GET);
	
	/*$urunler = array(1,2,3,4,5);*/
	$urunlerFiyati = array(60,90,30,50,150);
	$toplamtutar=0;
	
	
	if ( isset($_GET['sepetim']) ){
		if ( isset($_COOKIE['urun']) )
		echo 'Sepetinizde  <strong>'.count($_COOKIE['urun']).' adet </strong> ürün bulunmaktadır. <a href="?tumurunler=true">[Listeye Geri Dön]</a> ';
		
		if ( isset($_COOKIE['urun']) ){
			foreach ( $_COOKIE['urun'] as $urun => $val ){
				
				  while($oku = mysqli_fetch_object($sonuc))
    {
		
				echo '<div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px">
			<strong>Fiyatı:'.$oku->Fiyati.' TL
					<h2>'.$urokuun->UrunAdi.' </h2>
					<img src="'.$urokuun->Link.'"></img>
					<a href="?cikart='.$urun.'">[sepetten çıkart]</a>
				</div>';
			break;
		
	}
				
			
			}	
			echo '<div style="color:red"><h1>Toplam Tutar: '.$toplamtutar.' TL <h1></div>';
		} else {
			header('Location: sepet.php');
			echo 'Sepetinizde hiç ürün bulunmuyor.';
		}
		
	} 
	else {
	
		/* sepette kaç tane ürün var? */
		if ( isset($_COOKIE['urun']) ){
			echo 'Şuan sepetinizde <strong>'.count($_COOKIE['urun']).' adet ürün</strong> bulunuyor! <a href="?sepetim=true">[Sepetimi Göster]</a> / <a href="?bosalt=true">[Sepeti Boşalt]</a>';
		} else {
			echo 'Şuan sepetinizde hiç ürün bulunmuyor!';
		}
		
	
		/* ürünleri listeleyelim */

	  while($oku = mysqli_fetch_object($sonuc))
    {
				echo '<div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px">
			<strong>Fiyatı:'.$oku->Fiyati.' TL
					<h2>'.$oku->Id.' - '.$oku->UrunAdi.'</h2>
					<img src="'.$oku->Link.'"></img>
				'.(isset($_COOKIE['urun'][$oku->Id]) ? '<a href="?cikart='.$oku->Id.'">[sepetten çıkart]</a>' : '<a href="?ekle='.$oku->Id.'">[sepete ekle]</a>').'
				</div>';
				
		}
	
	}
	
	 if( isset($_GET['tumurunler']) ){
		header('Location: sepet.php');
	 }
	
	if ( isset($_GET['bosalt']) ){
		foreach ( $_COOKIE['urun'] as $key => $val ){
			setcookie('urun['.$key.']', $key, time() - 86400);
		}
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
	
	if ( isset($_GET['bosalt']) ){
		foreach ( $_COOKIE['urun'] as $key => $val ){
			setcookie('urun['.$key.']', $key, time() - 86400);
		}
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
	
	if ( isset($_GET['ekle']) ){
		$id = $_GET['ekle'];
		setcookie('urun['.$id.']', $id, time() + 86400);
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
	
	if ( isset($_GET['cikart']) ){
		setcookie('urun['.$_GET['cikart'].']', $_GET['cikart'], time() - 86400);
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}

?>

</body>
</html>