<?php
	ob_start();
	include('impressao/codigo_produto.php');
	$conteudo = ob_get_contents();
	ob_end_clean();

	$mdpf = new mPDF();
	$mdpf->WriteHTML($conteudo);
	$mdpf->Output();
?>
