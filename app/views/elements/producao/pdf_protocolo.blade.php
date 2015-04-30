<!DOCTYPE html>
<html>
<head>

<title>Protocolo </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
body,div,p,a,input,table,form,aside,section,article,header,footer,h1,h2,h3,h4,h5,h6
	{
	padding: 0;
	margin: 0;
}

body {
	font-family: sans-serif;
	font-size: 12px;
}

table {
	/*border-collapse: collapse;*/
}

.pull-right {
	float: right;
}

.pull-left {
	float: left;
}

.text-right {
	text-align: right;
}

.text-center {
	text-align: center;
}

.text-left {
	text-align: left;
}

.page-header img {
	width: 200px;
}

#only-print-container {
	display: block;
}

#protocolo-interno {
	display: block;
}

@page {
	size: A4;
	
}

.print-page-break {
	page-break-after: always;
}

.main-content {
	/*width:1080px;*/
	width: 100%;
	border: none;
}

.container-lists-table {
	display: block;
	border-radius: 5px;
	overflow: hidden;
	margin: 10px 0;
}

.lists-table {
	width: 100%;
	border-collapse: collapse;
	box-sizing: border-box;

}

.lists-table thead th {
	font-weight: bold;
	padding: 5px;
}

.lists-table td,.lists-table th {
	border: thin solid #ccc;
	padding: 5px;
}

.gray-box {
	margin: 10px auto;
	background-color: whitesmoke;
	border-radius: 5px;
	border: thin #E3E3E3 solid;
	padding: 20px;
	box-sizing: border-box;
}

#box-to {
	font-size: 10px;
	width: 350px;
	padding: 0;
}

#box-to  table td,#box-to  table th {
	padding: 5px;
}

#codigo-barra {
	width: 130px;
}

#barcode-box {
	margin: 10px;
}

.tabela-protocolo-interno {
	width: 100%;
	text-align: left;
	border-collapse: collapse;
}

.tabela-protocolo-interno td,.tabela-protocolo-interno th {
	border: thin solid black;
	padding: 5px;
}

.footer-print {
	position: absolute;
	bottom: 0;
	width: 100%;
}
</style>
</head>
<body>
	<section id="protocolo-interno" class="print-page-break">
		<header class="page-header">
			<div class="pull-right text-right">
				<p>Let´scom</p>
				<p>www.letscom.com.br</p>
			</div>
			<img src="{{ URL::to('img/logo-tmt.png') }}" />
		</header>

		<h1 class="text-center">Protocolo Interno - {{ zero_fill($remessa->id, 4) }}</h1>

		<div class="container-lists-table">
			<h2>Ficha Técnica</h2>
			<table class="tabela-protocolo-interno">
				<tr>
					<th width="20%">Nome do modelo</th>
					<td>{{ $remessa->fichaTecnica->nome }}</td>
				</tr>
				<tr valign="top">
					<th>Tipos de Cartão</th>
					<td>
						@foreach($remessa->fichaTecnica->tiposCartao as $tipoCartao)
							<div>{{ $tipoCartao->nome }}</div>
						@endforeach

					</td>
				</tr>
				<tr>
				</tr>
				<tr>
					<th>Furo</th>
					<td>{{ $remessa->fichaTecnica->tem_furo ? 'Sim' : 'Não' }}</td>
				</tr>
				<tr>
					<th>Tem Cardvantagens</th>
					<td>{{ $remessa->fichaTecnica->tem_cv ? 'Sim' : 'Não' }}</td>
				</tr>
			</table>
		</div>

		<!-- 
		<div class='container-lists-table'>
			<h2>Observações</h2>
			<table class="tabela-protocolo-interno">
				<tbody>
					<tr>
						<th width="20%">Impressão</th>
						<td>Impressão do layout da carteirinha em impressora de FOTO.</td>
					</tr>
					<tr>
						<th>Impressão</th>
						<td>Após impressão do layout da carteirinha o código de barras deve ser impresso na impressora 4.</td>
					</tr>
					<tr>
						<th>Impressão</th>
						<td>Chip 125khz</td>
					</tr>
					<tr>
						<th>Codificação</th>
						<td>Impressão termo do código "W"</td>
					</tr>
				</tbody>
			</table>
		</div>
		-->

		<h2>Fabricação</h2>

		<table class="tabela-protocolo-interno">
			<tr>
				<th>Processo</th>
				<th>Responsável</th>
				<th>Data</th>
				<th>Situação</th>
			</tr>
			<tr>
				<td width='20%'>Aprovação da Foto</td>
				<td width='35%'>{{{ $remessa->usuario->nome }}}</td>
				<td>{{ $remessa->created_at->format('d/m/Y') }}</td>
				<td width="20%"></td>
			</tr>
			<tr>
				<td>Impressor</td>
				<td>{{{ $user->nome }}}</td>
				<td>{{ (new DateTime('now'))->format('d/m/Y') }}</td>
				<td width="20%"></td>
			</tr>
			<tr>
				<td>Qualidade</td>
				<td></td>
				<td></td>
				<td width="20%"></td>
			</tr>
			<tr>
				<td>Impressão de dados variáveis</td>
				<td></td>
				<td></td>
				<td width="20%"></td>
			</tr>
		</table>
	</section>

	<section class="print-page-break">

		<header class="page-header">
			<div class="pull-right text-right">
				<p>Let´scom</p>
				<p>www.letscom.com.br</p>
			</div>
			<img src="{{ URL::to('img/logo-tmt.png') }}" />
		</header>


		<h1 class='on-print text-center'>Protocolo para Entrega de Cartões</h1>

		<div id="box-to" class="gray-box">
			<h3>Destinatário</h3>
			<table>
				<tr>
					<td>Pessoa p/ contato:</td>
					<td>Tatiana</td>
				</tr>
				<tr>
					<td>Remessa:</td>
					<td>{{ zero_fill($remessa->id, 4) }}</td>
				</tr>
				<tr>
					<td>Endereço:</td>
					<td>R.Uberaba, Nº 295 - 13º Andar - Barro Preto - Belo Horizonte/MG</td>
				</tr>
				<tr>
					<td>Tipo de entrega</td>
					<td>{{ $remessa->fichaTecnica->tipo_entrega->nome }}</td>
				</tr>
			</table>

			<div class="text-center" id="barcode-box">
				<img id="codigo-barra"
					src="{{ URL::to(DNS1D::getBarcodePNGPath(zero_fill($remessa->id, 10), 'I25', 4, 90)) }}" />
				<div>{{ zero_fill($remessa->id, 10) }}</div>
			</div>
		</div>


		<div class="container-lists-table">
			<table class="lists-table protocolo-lista-alunos">
				<thead>
					<tr>
						<th style="width: 20px"></th>
						@foreach($remessa->fichaTecnica->camposVariaveis as $cabecalho)
							<th>{{ $cabecalho->nome }}</th>
						@endforeach
						<th>Recebido em:</th>
						<th>Assinatura</th>
					</tr>
				</thead>
				<tbody>

					@foreach($remessa->solicitacoes as $i => $solicitacao)

					<tr>
						<td>{{ ++$i }}</td>
						@foreach($solicitacao->camposVariaveis as $campo)						
							<td>{{ $campo->pivot->valor }}</td>
						@endforeach
						<td width="20%" class="text-center">____ /____ /____</td>
						<td>x</td>
					</tr>

					@endforeach

				</tbody>
			</table>
		</div>


		<div class='gray-box'>
			A <strong>Prefeitura de Belo Horizonte</strong> declara ter recebido da empresa TMT
			Soluções em Tecnologia LTDA (CNPJ: 11.720.787/0001-82) .
		</div>


		<div class="container-lists-table">
			<table class="lists-table">
				<tr>
					<th class="text-left" colspan='3'>Belo Horizonte, {{{ strftime('%d de %B de %Y ') }}}</th>
				</tr>
				<tr>
					<td style="width: 150px" rowspan='2' class='text-center text-muted'>Carimbo
						da Empresa</td>
					<td class='text-center'><br />
						<div>_________________________________________________________</div>
						<div>Responsável pelo recebimento (Nome Completo Legível)</div> <br />
					</td>
					<td class='text-center'><br />
						<div>____________________</div>
						<div>RG ou CPF</div> <br /></td>

				</tr>
				<tr>
					<td colspan="2" class='text-center'><br />
						<div>____________________________________________________________</div>
						<div>Assinatura</div> <br />
						<div class="text-left">Data do Recebimento: ____/____/______</div>
						<br /></td>
				</tr>
				</tbody>
			</table>

			<br />

			<table class="lists-table">
				<thead>
					<tr>
						<th colspan="2" class='text-left'>Retirado e conferido por:
							________________________________________________</th>
						<th class="text-left">Data: <span>___/___/_____</span>
						</th>
					</tr>
				</thead>
			</table>
		</div>

		<div class="footer-print">
			Let´scom &copy; {{(new Datetime)->format('Y') }}
		</div>
	</section>

</body>
</html>