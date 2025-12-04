# ⚡ Quick Start - Sistema ACE MVC

## 🚀 Iniciar em 2 Minutos

### Passo 1: Verificar Banco de Dados
```bash
# Confirme que o banco 'sistema_ace' existe
mysql -u root -p sistema_ace -e "SELECT COUNT(*) FROM area;"
```

### Passo 2: Atualizar Credenciais
Edite: `config/database.php`
```php
private $usuario = "root";    // SEU USUÁRIO
private $senha = "";           // SUA SENHA
```

### Passo 3: Iniciar Servidor
```bash
# Opção A: PHP Built-in (Recomendado para testes)
cd c:\Users\gerao\Downloads\sistema_ace\sistema_ace
php -S localhost:8000 -t public/

# Opção B: Apache (htdocs)
# Copiar pasta para C:\xampp\htdocs\sistema_ace
# Acessar: http://localhost/sistema_ace/public/
```

### Passo 4: Acessar Aplicação
Abra seu navegador:
```
http://localhost:8000/
```

---

## 🎯 Teste Rápido (2 min)

1. ✅ Página carrega → Dashboard com números
2. ✅ Clique "Iniciar" → Lista áreas
3. ✅ Clique "Ver Quarteirões" → Lista quarteirões
4. ✅ Clique "Ver Imóveis" → Lista imóveis
5. ✅ Clique "Trabalhar" → Abre formulário de visita

**Tudo funcionando? Perfeito! 🎉**

---

## 📋 Arquivos Principais

```
public/index.php          ← Ponto de entrada (NÃO ALTERE)
config/database.php       ← Credenciais (ALTERE AQUI)
app/Controllers/          ← Lógica das ações
app/Models/               ← Lógica do banco
app/Views/                ← Páginas HTML
```

---

## 🔗 URLs Principais

| Ação | URL |
|------|-----|
| Home | `/` |
| Áreas | `?action=area-index` |
| Quarteirões | `?action=quarteirao-list&cod_area=01` |
| Imóveis | `?action=imovel-list&id_quarteirao=1` |
| Visita | `?action=visita-show&id_imovel=1` |

---

## ⚠️ Erros Comuns

### "Erro de conexão"
→ Verifique `config/database.php`

### "Página em branco"
→ Procure por erros em `public/index.php`

### "404 Not Found"
→ Use URL com query string: `?action=dashboard`

---

## ✅ Verificação Final

- [ ] Banco de dados conectado
- [ ] Dashboard carrega
- [ ] Links funcionam
- [ ] Dados salvam
- [ ] Sem erros no console (F12)

---

**Tudo pronto?** → Leia `README.md` para documentação completa!
