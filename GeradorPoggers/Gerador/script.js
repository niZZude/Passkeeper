let sliderElement = document.querySelector("#slider");
let buttonElement = document.querySelector("#button");

let sizePassword = document.querySelector("#valor");
let password = document.querySelector("#password");

let containerPassword = document.querySelector("#container-password");

let novaSenha = '';
let ultimasSenhas = []; // Array para armazenar as últimas 5 senhas geradas

const minusculas = 'abcdefghijklmnopqrstuvwxyz';
const maiusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
const numeros = '0123456789';
const simbolos = '!@#$%¨&()_-+=';

sizePassword.innerHTML = sliderElement.value;

slider.oninput = function() {
    sizePassword.innerHTML = this.value;
}

function generatePassword(){
  let charset = '';

  if(document.querySelector("#incluirMaiuscula").checked) charset += maiusculas;
  if(document.querySelector("#incluirMinuscula").checked) charset += minusculas;
  if(document.querySelector("#incluirNumero").checked) charset += numeros;
  if(document.querySelector("#incluirSimbolo").checked) charset += simbolos;

  let pass = '';
  for(let i = 0, n = charset.length; i < sliderElement.value; ++i){
    pass += charset.charAt(Math.floor(Math.random() * n));
  }

  // Adicionar a nova senha ao array e manter apenas as últimas 5
  ultimasSenhas.unshift(pass);
  if (ultimasSenhas.length > 5) {
    ultimasSenhas.pop();
  }

  console.log(pass);
  containerPassword.classList.remove("hide");
  password.innerHTML = pass;
  novaSenha = pass;
}

function copyPassword() {
  alert("Senha copiada com sucesso!");
  navigator.clipboard.writeText(novaSenha);
}

function downloadSenhas() {
  // Gera o conteúdo do arquivo com as últimas 5 senhas
  const conteudo = ultimasSenhas.join('\n');

  // Cria um Blob com o conteúdo
  const blob = new Blob([conteudo], { type: 'text/plain' });

  // Cria um link para download
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'ultimas_senhas.txt';

  // Clica no link para iniciar o download
  link.click();

  // Libera o objeto URL após o download
  URL.revokeObjectURL(link.href);
}

// Adicione o evento de clique ao botão para download das senhas
document.querySelector("#download").addEventListener("click", downloadSenhas);

