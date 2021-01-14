# aws-mail-sns-notification

**

# Descrição

O pacote fornece um middleware para manipular as notificações enviadas para endpoints cadastrados no AWS SNS Subscriptions para eventos de uma Configuration SET do AWS SES.

**Notificação 'SubscriptionConfirmation':**

 - 	Feito log da url enviada pela AWS para confirmar a inscrição do endpoint;
 -	Enviado uma requisição GET para a url informada pela AWS para confirmar a inscrição;

**Notificação 'UnsubscribeConfirmation':**

 - 	Feito log da url enviada pela AWS caso queira se inscrever novamente;

**Notificação 'Notification':**

 - 	Realizado conexão no database usando o tenant retornado nos headers originais do e-mail enviado (x-tenant-name);
 - Injetado na instância $request do Laravel a instância das classes NotificationMessage e NotificationMail referentes à notificação recebida;

# Configuração na AWS:

**AWS SNS**

-	Criar tópico do tipo **STANDARD**
-	Criar inscrição **HTTP** ou **HTTPS** (Não marcar a opção **Enable raw message delivery**)

**AWS SES**

- Criar **Configuration SET**;
- Selecionar a opção **SNS** em **Add Destination** da configuration set criada;
- Criar a **SNS Destination** selecionando os eventos que preferir e um tópico SNS para ser associado;
- Adicionar o header **X-SES-CONFIGURATION-SET** com o nome da **Configuration SET** criada nos e-mails que desejar receber as notificações;

# Uso:

**Arquivo de configuração customizado**

    php artisan vendor:publish --provider="Multiplier\AwsMailSnsNotification\AwsMailSnsNotificationServiceProvider" --tag="config"

**Variáveis .env**

    SNS_HEADER_TENANT_NAME (default = 'x-tenant-name')
    SNS_HEADER_MAIL_IDENTIFIER (default = 'x-mail-identifier')

**Middleware para usar no endpoint cadastrado no AWS SNS Subscriptions**

    ->middleware('aws.mail.sns.notification')


**
