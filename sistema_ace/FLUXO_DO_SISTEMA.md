<!-- Arquivo FLUXO_DO_SISTEMA.md -->

# 🏥 Fluxo do Sistema ACE - Endemias

## Mapa de Navegação Completo

```
┌─────────────────────────────────────────────────────────────────┐
│                      📍 INDEX.PHP (HOME)                         │
│        Sistema ACE - Área de Controle de Endemias              │
│  [Áreas] [Cadastrar Imóvel] [Registrar Visita] [Estatísticas]  │
└─────────┬──────────────────────────────────────────────────────┘
          │
          ├──────────────────────────────────────────────────────┐
          │                                                        │
          ▼                                                        ▼
┌──────────────────────┐                          ┌──────────────────────┐
│    AREA.PHP          │                          │   CADASTRO.PHP       │
│ 📋 Lista de Áreas    │                          │ 📝 Cadastrar Imóvel  │
│                      │                          │                      │
│ • Código             │                          │ • Quarteirão (select)│
│ • Zona               │                          │ • Nome da Rua        │
│ • Nome da Área       │                          │ • Número             │
│ • Qtd. Quarteirões   │                          │ • Tipo do Imóvel     │
│ • [Trabalhar] ────────────────────────────────→ │ • Qtd. Habitantes    │
└──────────────────────┘                          │ • Qtd. Cães          │
          ▲                                       │ • Qtd. Gatos         │
          │                                       │ • [Cadastrar]        │
          └───────────────────────────────────────┴─ [Voltar] ◄─────────┘
                                                     (index.php)

                    ┌──────────────────────────────────┐
                    │         RG.PHP                    │
                    │ 📊 Registro Geográfico            │
                    │ (Quarteirões por Área)            │
                    │                                  │
                    │ • Quarteirão                      │
                    │ • Imóveis                         │
                    │ • Residências                     │
                    │ • Comércio                        │
                    │ • Habitantes                      │
                    │ • Cães / Gatos                    │
                    │ • [Trabalhar] ───────────┐        │
                    └───────────────┬───────────┼────┘  │
                                    │           │       │
                                    ▼           │       │
┌──────────────────────────────────────────┐   │       │
│        IMOVEIS.PHP                       │   │       │
│ 🏘️ Lista de Imóveis por Quarteirão       │   │       │
│                                          │   │       │
│ • N° Quarteirão                          │   │       │
│ • Nome da Rua                            │   │       │
│ • Número                                 │   │       │
│ • Tipo                                   │   │       │
│ • Habitantes / Cães / Gatos              │   │       │
│ • [Trabalhar] ──────────────────────────┐│   │       │
└──────────┬───────────────────────────────┘│   │       │
           │                                │   │       │
           ▼                                ▼   │       │
┌──────────────────────────────────────────────┐│       │
│        VISITA.PHP                            ││       │
│ 🏠 Registrar Visita Domiciliar               ││       │
│                                              ││       │
│ • Logradouro (readonly)                      ││       │
│ • Número (readonly)                          ││       │
│ • Tipo do Imóvel (readonly)                  ││       │
│ • Habitantes (readonly)                      ││       │
│ • Tipo de Visita (Normal / Repasse)          ││       │
│ • Hora da Visita                             ││       │
│ • [Próximo: Registrar Depósitos →]           ││       │
│ • [← Voltar]                                 ││       │
└──────────┬───────────────────────────────────┘│       │
           │                                    │       │
           └────────────────────────────────────┼───────┘
                                                │
                                                ▼
                    ┌──────────────────────────────────┐
                    │      DEPOSITO.PHP                 │
                    │ 📋 Registrar Depósitos            │
                    │                                  │
                    │ • Imóvel (informativo)            │
                    │ • Tipo (informativo)              │
                    │ • Quantidade de A1                │
                    │ • Focos de A1 encontrados         │
                    │ • Quantidade de Larvicida         │
                    │ • [💾 Salvar Depósitos]           │
                    │ • [← Voltar]                      │
                    └──────────────────────────────────┘
```

## Fluxo Detalhado de Dados

### 1️⃣ Início (INDEX.PHP)

- **Função**: Dashboard inicial com estatísticas
- **Dados Exibidos**:
  - Total de Áreas
  - Total de Imóveis
  - Total de Visitas
- **Navegação**:
  - 📍 Gerenciar Áreas → area.php
  - 📝 Cadastrar Imóvel → cadastro.php
  - 🏠 Registrar Visita → visita.php (requer id_imovel)

### 2️⃣ Gestão de Áreas (AREA.PHP)

- **Função**: Listar todas as áreas cadastradas
- **Banco de Dados**: SELECT \* FROM area
- **URL Parameters**: Nenhum
- **Ação Trabalhar**:
  - Link → rg.php?cod_area={cod_area}

### 3️⃣ Registro Geográfico (RG.PHP)

- **Função**: Mostrar quarteirões de uma área
- **Banco de Dados**: SELECT \* FROM registro_geografico WHERE cod_area = ?
- **URL Parameters**: cod_area
- **Validação**: SQL Injection Prevention com Prepared Statements
- **Ação Trabalhar**:
  - Link → imoveis.php?id_quarteirao={id_quarteirao}

### 4️⃣ Cadastro de Imóvel (CADASTRO.PHP)

- **Função**: Formulário para cadastrar novo imóvel
- **Banco de Dados**:
  - SELECT FROM registro_geografico (carregar quarteirões)
  - INSERT INTO imovel
- **Campos Inseridos**:
  - id_quarteirao (select obrigatório)
  - nome_rua (texto obrigatório)
  - numer_imovel (número obrigatório)
  - tipo_imovel (select obrigatório)
  - qtd_habitantes (número opcional)
  - qtd_caes (número opcional)
  - qtd_gatos (número opcional)

### 5️⃣ Lista de Imóveis (IMOVEIS.PHP)

- **Função**: Mostrar imóveis de um quarteirão
- **Banco de Dados**: SELECT \* FROM imovel WHERE id_quarteirao = ?
- **URL Parameters**: id_quarteirao
- **Validação**: SQL Injection Prevention
- **Ação Trabalhar**:
  - Link → visita.php?id_imovel={id_imovel}

### 6️⃣ Registrar Visita (VISITA.PHP)

- **Função**: Coletar dados da visita domiciliar
- **Banco de Dados**:
  - SELECT \* FROM imovel WHERE id_imovel = ?
  - INSERT INTO visita
- **URL Parameters**: id_imovel
- **Validação**: Verifica se imóvel existe
- **Ações**:
  - Cria registro na tabela visita automaticamente
  - Obtém id_visita para próxima etapa
- **Campos Coletados**:
  - tipo_visita (Normal / Repasse)
  - hora_visita
- **Ação Submit**:
  - POST → deposito.php?id_visita={id_visita}

### 7️⃣ Registrar Depósitos (DEPOSITO.PHP)

- **Função**: Finalizar com informações sobre depósitos
- **Banco de Dados**:
  - SELECT FROM visita+imovel (informativo)
  - INSERT INTO deposito
- **URL Parameters**: id_visita
- **Validação**: Verifica se visita existe
- **Campos Inseridos**:
  - a1 (quantidade)
  - focos_a1 (quantidade)
  - larvicida (quantidade em litros)

## Medidas de Segurança Implementadas

✅ **SQL Injection Prevention**

- Todas as queries usam Prepared Statements
- Parâmetros validados com (int) casting
- htmlspecialchars() em outputs

✅ **Validação de Dados**

- Verificação se registros existem antes de usar
- Validação de tipos de dados
- Tratamento de erros com mensagens apropriadas

✅ **XSS Prevention**

- Uso de htmlspecialchars() em todos os outputs
- Atributos de formulário escapados

## Tabelas do Banco de Dados

```sql
-- Áreas
area: cod_area, cod_zona, nome_area, qtd_quarteiroes, ...

-- Registro Geográfico (Quarteirões)
registro_geografico: id_quarteirao, numero_quarteirao, cod_area, ...

-- Imóveis
imovel: id_imovel, id_quarteirao, nome_rua, numer_imovel, tipo_imovel, ...

-- Visitas
visita: id_visita, id_imovel, tipo, data_visita, ...

-- Depósitos
deposito: id_deposito, id_visita, a1, focos_a1, larvicida, ...
```

## URLs Válidas do Sistema

```
index.php                                   → HOME
area.php                                    → Lista Áreas
rg.php?cod_area=1                          → Quarteirões da Área 1
cadastro.php                                → Cadastro de Imóvel
imoveis.php?id_quarteirao=1                → Imóveis do Quarteirão 1
visita.php?id_imovel=1                     → Visita do Imóvel 1
deposito.php?id_visita=1                   → Depósitos da Visita 1
```

---

**Desenvolvido para**: Controle de Endemias - Dengue, Zika e Chikungunya
**Data**: Dezembro 2025
