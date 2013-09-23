<?php
$classe = $_GET['classe'];
?>
<!DOCTYPE html>
<html>
<head>
<meta property="og:title" content="<?php echo 'Titolo della pagina di un ' . $classe; ?>" />
<meta property="og:description" content="<?php echo 'Descrizione della pagina di un ' . $classe; ?>" />
<meta property="og:image" content="http://launchrock-assets.s3.amazonaws.com/logo-files/CM3BNZBC_1365245910190.png" />
</head>
<body>
<script type="text/javascript">window.location="http://www.piombino2.it/page.php?id=1&classe=<?php echo $classe; ?>"</script>
JavaScript redirect unsuccessful. Click <a href="http://www.piombino2.it/page.php?id=1&classe=<?php echo $classe; ?>">here</a> to continue.
</body>
</body>
</html>