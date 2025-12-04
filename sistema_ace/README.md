# Sistema ACE - Estrutura MVC

## 📋 Descrição
Sistema de monitoramento de endemias refatorado para o padrão MVC (Model-View-Controller) mantendo toda funcionalidade original e compatibilidade com o banco de dados existente.

## 📁 Estrutura do Projeto

```
sistema_ace/
├── app/
│   ├── Controllers/          # Controllers da aplicação
│   │   ├── AreaController.php
│   │   ├── QuarteiraoController.php
│   │   ├── ImovelController.php
│   │   ├── VisitaController.php
│   │   └── DashboardController.php
│   ├── Models/              # Models (lógica de dados)
│   │   ├── Area.php
│   │   ├── Quarteirao.php
│   │   ├── Imovel.php
│   │   ├── Visita.php
│   │   └── Deposito.php
│   └── Views/               # Views (apresentação)
│       ├── dashboard/
│       ├── area/
│       ├── quarteirao/
│       ├── imovel/
│       └── visita/
├── config/
│   └── database.php         # Configuração de banco de dados
├── public/
│   ├── index.php            # Ponto de entrada da aplicação (Router)
│   └── .htaccess            # Configuração de reescrita de URLs
├── script.sql               # Script para criar o banco de dados
└── README.md               # Este arquivo
```

## 🚀 Como Usar

### 1. Configuração Inicial

1. **Certifique-se de que o banco de dados está criado:**
   - Execute o arquivo `script.sql` no seu MySQL
   - O banco deve estar nomeado como `sistema_ace`

2. **Verifique as credenciais do banco em `config/database.php`:**
   ```php
   private $host = "localhost";      // Host do MySQL
   private $usuario = "root";         // Usuário MySQL
   private $senha = "";               // Senha MySQL
   private $db = "sistema_ace";       // Nome do banco
   private $port = 3306;              // Porta MySQL
   ```

### 2. Configurar o Servidor Web

**Opção A: Apache com mod_rewrite**
- Copie os arquivos para o seu diretório web (htdocs ou www)
- Verifique se o mod_rewrite está habilitado
- Acesse: `http://localhost/sistema_ace/public/`

**Opção B: PHP Built-in Server (Desenvolvimento)**
```bash
cd /caminho/para/sistema_ace
php -S localhost:8000 -t public/
```
- Acesse: `http://localhost:8000/`

**Opção C: Criar um Virtual Host**
- Configure um virtual host apontando para `/sistema_ace/public/`
- Acesse: `http://sistema-ace.local/` (ou o domínio configurado)

### 3. Acessar a Aplicação
- Abra seu navegador e vá para `http://localhost/sistema_ace/public/`
- Você será redirecionado para o dashboard automaticamente

## 📖 Padrão MVC

### Model (Modelos)
- **Responsabilidade**: Gerenciar dados e lógica de negócio
- **Localização**: `app/Models/`
- **Classes**: Area, Quarteirao, Imovel, Visita, Deposito
- **Comunicação**: Direta com banco de dados via `mysqli`

### View (Visualizações)
- **Responsabilidade**: Apresentação dos dados ao usuário
- **Localização**: `app/Views/`
- **Características**: HTML/CSS puro, sem lógica de negócio
- **Acesso aos dados**: Através de variáveis passadas pelos Controllers

### Controller (Controladores)
- **Responsabilidade**: Processar requisições e coordenar Model/View
- **Localização**: `app/Controllers/`
- **Métodos**: Ações específicas (ex: create, show, list)
- **Fluxo**: Recebe requisição → Chama Model → Carrega View

## 🔄 Fluxo de Requisições

```
1. Usuario acessa: http://localhost/sistema_ace/public/?action=area-index
2. index.php (Router) recebe a requisição
3. Router identifica a ação e instancia o Controller apropriado
4. Controller chama o Model para buscar dados
5. Controller carrega a View correspondente
6. View renderiza os dados para o usuário
```

## 📝 Exemplos de URLs

| Ação | URL |
|------|-----|
| Dashboard | `?action=dashboard` |
| Listar Áreas | `?action=area-index` |
| Listar Quarteirões | `?action=quarteirao-list&cod_area=01` |
| Listar Imóveis | `?action=imovel-list&id_quarteirao=1` |
| Cadastrar Imóvel | `?action=imovel-create&id_quarteirao=1` |
| Exibir Visita | `?action=visita-show&id_imovel=1` |
| Adicionar Depósito | `?action=visita-add-deposito` (POST) |
| Finalizar Visita | `?action=visita-finish&id_visita=1` |

## 🔐 Segurança

- ✅ Uso de **Prepared Statements** para prevenir SQL Injection
- ✅ Validação de entrada com `htmlspecialchars()`
- ✅ Type casting de IDs para inteiros
- ✅ Tratamento de erros com try/catch

## 📚 Como Adicionar uma Nova Feature

### 1. Criar um novo Model
```php
// app/Models/NovoModelo.php
class NovoModelo {
    private $conn;
    
    public function __construct($connection) {
        $this->conn = $connection;
    }
    
    public function getAll() {
        // Implementar lógica
    }
}
```

### 2. Criar um Controller
```php
// app/Controllers/NovoController.php
class NovoController {
    private $modelo;
    
    public function __construct($connection) {
        require_once __DIR__ . '/../Models/NovoModelo.php';
        $this->modelo = new NovoModelo($connection);
    }
    
    public function index() {
        $dados = $this->modelo->getAll();
        require_once __DIR__ . '/../Views/novo/index.php';
    }
}
```

### 3. Criar as Views
```php
<!-- app/Views/novo/index.php -->
<!DOCTYPE html>
<html>
    <!-- HTML da página -->
</html>
```

### 4. Adicionar rota em `public/index.php`
```php
case 'novo-index':
    require_once __DIR__ . '/app/Controllers/NovoController.php';
    $controller = new NovoController($conn);
    $controller->index();
    break;
```

## 🐛 Troubleshooting

### "Página não encontrada"
- Verifique se a ação está registrada em `public/index.php`
- Verifique a sintaxe da URL (ex: `?action=correta`)

### "Erro de conexão com banco de dados"
- Verifique credenciais em `config/database.php`
- Certifique-se de que o MySQL está rodando
- Verifique se o banco `sistema_ace` existe

### "Blank Page"
- Verifique logs do PHP: `php -l caminho/arquivo.php`
- Ative exibição de erros em `config/database.php`
- Verifique permissões de arquivo

## ✨ Benefícios da Refatoração MVC

✅ **Separação de Responsabilidades**: Código mais organizado e manutenível  
✅ **Reutilização de Código**: Models podem ser usados em múltiplos Controllers  
✅ **Testes Mais Fáceis**: Lógica isolada é mais testável  
✅ **Escalabilidade**: Fácil adicionar novas features  
✅ **Manutenção**: Erros localizados em áreas específicas  
✅ **Banco de Dados Protegido**: Nenhuma mudança na estrutura existente  

## 📞 Suporte

Para dúvidas ou problemas, verifique:
1. Arquivo de log do PHP/Apache
2. Console do navegador (F12)
3. Estrutura de diretórios
4. Permissões de arquivo

---

**Versão**: 1.0  
**Padrão**: MVC  
**Data**: 2025-12-04
