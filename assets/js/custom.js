var form = document.getElementById("rolform");

if (form.addEventListener) {                   
    form.addEventListener("submit", validaForm);
} else if (form.attachEvent) {                  
    form.attachEvent("onsubmit", validaForm);
}

function PopUP(URL, Janela)
{
var Objeto = window.open(URL, Janela)
Objeto.focus();
}

function validaForm(evt){
	var saldoconta = document.getElementById('saldoconta').trim();
	var suplementacao = document.getElementById('suplementacao').trim();
	var devolve = document.getElementById('devolve').trim();
	var datafim = document.getElementById('datafim');
	var contErro = 0;


	/* Validação do campo saldoconta */
	caixa_saldoconta = document.querySelector('.msg-saldoconta');
	if((saldoconta.value == "") || (saldoconta.length<4)) {
		caixa_saldoconta.innerHTML = "O campo <b>Saldo</b> é requerido e deve ter ao menos três digitos";
		caixa_saldoconta.style.display = 'block';
		contErro += 1;
	}else{
		caixa_saldoconta.style.display = 'none';
	}

	/* Validação do campo suplementacao */
	caixa_suplementacao = document.querySelector('.msg-suplementacao');
	if((suplementacao.value == "") || (suplementacao.length<4)) {
		caixa_suplementacao.innerHTML = "O campo <b>Suplementação</b> é requerido e deve ter ao menos três digitos";
		caixa_suplementacao.style.display = 'block';
		contErro += 1;
	}else{
		caixa_suplementacao.style.display = 'none';
	}

	/* Validação do campo devolve */
	caixa_devolve = document.querySelector('.msg-devolve');
	if((devolve.value == "") || (devolve.length<4)) {
		caixa_devolve.innerHTML = "O campo <b>Devolução</b> é requerido e deve ter ao menos três digitos";
		caixa_devolve.style.display = 'block';
		contErro += 1;
	}else{
		caixa_devolve.style.display = 'none';
	}

	if(contErro > 0){
		evt.preventDefault();
	} else {
		PopUP('relatorios/printRelatorio/'+datafim, '');
		'relatorios/printResumo'; 
	}
}