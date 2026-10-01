# Sistema de agendamento pra um consultório

**Regras Cliente**

- O sistema vai receber um usuario por meio do cadastro
- O usuario vai fornecer informações básicas que forem pedidas
- O usuario poderá agendar uma consulta assim que for verificado
- Poderá escolher um médico, um horário e o modelo de pagamento
- Pra realizar o agendamento, uma porcentagem da consulta será cobrado para garantir que nem ele cancele e muito menos o consultório
- Caso haja cancelamento do cliente, ee não receberá o que foi pago
- Caso haja cancelamento do consultório, ele terá de ou remarcar e descontar o valor, ou devolver o valor (depende do que o cliente quiser)

**Lembretes do usuário**

- O lembrete da consulta será enviado 24hrs antes da consulta
- Em caso de cancelamento, deverá ser pelo menos 2hrs antes (rever isso)

**Regras Administrador |  Consultório**

- O administrador fará o cadastro dos médicos
- Cada médico téra também um acesso diferente para ver sua agenda e relatórios da consulta, seus clientes e faturamento (talvez)
- Em caso de cliente romper com o consultório, somente o administrador poderá manusear de usuario ativo para inativo

**Regras do médico**

- Sempre que finalizar consulta, marcar como concluido, deixar observações se necessário de volta do paciente
- Sempre enviar o relatório do dia para um bom controle

**Tabelas**

- pacientes
- medicos
- areas da medicina
- agendamentos
- pagamentos
- lembretes

# ainda vamos resolver isso

**Regras**

- um paciente só pode ter um agendamento
- um medico pode ter varios pacientes
- um medico pode ter uma função