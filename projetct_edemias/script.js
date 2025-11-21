// Função chamada ao clicar em "Entrar" na tela de login
function fazerLogin() {
  const usuario = document.getElementById('usuario').value.trim();
  const senha = document.getElementById('senha').value.trim();

  if (usuario === "" || senha === "") {
    alert("Preencha todos os campos!");
    return;
  }

  // Simulação de login (pode conectar ao backend depois)
  if (usuario === "admin" && senha === "1234") {
    window.location.href = "visita.html";
  } else {
    alert("Usuário ou senha incorretos!");
  }
}

// Redireciona para a tela de "Esqueci minha senha"
function irParaEsqueciSenha() {
  window.location.href = "esqueci_senha.html";
}

// Volta para o login
function voltarLogin() {
  window.location.href = "index.html";
}

// Exibe mensagem e volta ao login após redefinir senha
function redefinirSenha() {
  const email = document.getElementById("email").value.trim();

  if (email === "") {
    alert("Por favor, informe seu e-mail para redefinir a senha.");
    return;
  }

  alert("Link de redefinição enviado para o e-mail informado.");
  window.location.href = "index.html";
}

// Simula o salvamento de visita
function salvarVisita() {
  alert("Visita registrada com sucesso!");
  window.location.href = "index.html";
}
