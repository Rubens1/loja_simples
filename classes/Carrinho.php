<?php 
	final class Carrinho{
		/*
			Construção do carrinho de compra
		*/
		public function __construct(){
			if(!isset($_SESSION['carrinho'])){
				$_SESSION['carrinho'] = array();
			}
		}
		/*
			Adicionar produto no carrinho 
		*/
		public function adicionarProdutos($id, $qtd = 1){	
			$indice = sprintf("%s", (int)$id);
			if(!isset($_SESSION['carrinho'][$indice])){
				$_SESSION['carrinho'][$indice] = (int)$qtd;
			}
		}
		/*
			Adicinoar mais produto na compra
		*/
		public function addItemCarrinho($indice){
			$_SESSION['carrinho'][$indice]++;
		}
		/*
			Remover produto na compra
		*/
		public function removerItem($indice){
			if(isset($_SESSION['carrinho'][$indice])){
				if($_SESSION['carrinho'][$indice] <= 1){
						unset($_SESSION['carrinho'][$indice]);
					}else{
				$_SESSION['carrinho'][$indice]--;
				}
			}
		}
		/*
			Excluir produtro da compra
		*/
		public function excluirProd($indice){
			unset($_SESSION['carrinho'][$indice]);
		}
		/*
			Lista todos os produtos no carrinho
		*/
		public function listarProdutos(){
			$retorno = array();
			foreach ($_SESSION['carrinho'] as $indice => $qtd) {
				$id = $indice;

				$query = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
				$query->execute(array($id));
				$resultado = $query->fetchObject();
				$retorno[$indice]['id'] = $id;
				$retorno[$indice]['id_categoria'] = $resultado->id_categoria;
				$retorno[$indice]['slug'] = $resultado->slug;
				$retorno[$indice]['nome'] = $resultado->nome;
				$retorno[$indice]['preco'] = $resultado->preco;
				$retorno[$indice]['preco_venda'] = $resultado->preco_venda;
				$retorno[$indice]['peso'] = $resultado->peso;
				$retorno[$indice]['comprimento'] = $resultado->comprimento;
				$retorno[$indice]['largura'] = $resultado->largura;
				$retorno[$indice]['altura'] = $resultado->altura;
				//if($qtd < $resultado->quantidade){
					$retorno[$indice]['quantidade'] = $qtd;
				//}else{
				//	$retorno[$indice]['quantidade'] = $resultado->quantidade;
				//}
				

				$retorno[$indice]['subtotal'] = $resultado->preco_venda * $qtd;

			}
			return $retorno;
		}
		/*
			Mostrar o valor total da compra
		*/
		public function valorTotal(){
			$produtos = Carrinho::listarProdutos();
			$total = 0;
				foreach($produtos as $indice => $linha){
					$total += $linha['subtotal'];
				}
			
			return $total;
		}
			
}
	
 ?>