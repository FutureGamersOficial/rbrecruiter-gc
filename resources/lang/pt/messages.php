<?php
/*
 * -- Information for translators | READ BEFORE TRANSLATING ANYTHING ---
 * In this file, only translate messages to the right, in this fashion:
 * 'something' => 'translate-me'
 * Also, don't translate, change, or move placeholders (:this-is-a-placeholder) starting with a colon.
 * Try to keep the message as close to the original in meaning as possible. These simple rules also apply to other files you're translating, such as:
 * auth.php, pagination.php, passwords.php, and validation.php.
 * It is VERY important that you "escape" single quotes with a backslash if they're present in your language, like this: I\'m an escaped quote
 *
 * Additionally, don't change anything in square or curly brackets, and don't remove pipe (|) characters.
 * If you see two messages separated by pipe, then usually the left side is singular and the right side is plural, so translate accordingly.
 *
 * Thank you for translating!
 */

return [

    // ============== MENU TRANSLATIONS ======================


    'menu' => [

        'my_apps' => 'As minhas Candidaturas',
        'current_apps' => 'Candidaturas Atuais',
        'profile_settings' => 'Configurações do Perfil',
        'hiring_man' => 'Gestão de Contratação',
        'all_forms' => 'Todos os Formulários',
        'app_settings' => 'Configurações da App',
        'global_app_settings' => 'Configurações globais do aplicativo',
        'system_logs' => 'Registos do Sistema'
    ],



    // ============== REUSABLE, GENERIC STRINGS ===============

    'reusable' => [
        'created_at' => 'Data de Criação',
        'updated_at' => 'Atualizado em',
        'actions' => 'Ações',
        'delete' => 'Apagar',
        'status' => 'Estado',
        'view' => 'Ver',
        'view_c' => 'Ver Detalhes',
        'no_access' => 'Acesso Negado à Aplicação',
        'validation_err' => 'Erro de validação!',
        'description' => 'Descrição',
        'join_date' => 'Data de inscrição',
        'my_acc' => 'Minha Conta',
        'confirm' => 'Por favor confirme',
        'confirm_plain' => 'Confirmar',
        'confirm_click' => 'Clique para confirmar',
        'date' => 'Data',
        'datetime' => 'Hora & Data',
        'location' => 'Local',
        'none_yet' => 'Nenhum ainda',
        'reason' => 'Motivo',
        'days' => 'Dias',
        'weeks' => 'Semanas',
        'months' => 'Meses',
        'years' => 'Anos',
        'yes' => 'Sim',
        'no' => 'Não',
        'roles' => 'Funções',
        'member_since' => 'Membro desde :date',
        'lookup' => 'Pesquisar :ipAddress',
        'abt' => 'Sobre',
        'acc' => 'Conta',
        'settings' => 'Definições',
        'profile' => 'Meu perfil',
        'code' => 'código',
        'here' => 'aqui',
        'auth_req' => 'Por favor autentique-se',
        'eligible' => 'Qualificado',
        'ineligible' => 'Não elegível',
        'schedule' => 'Agendar',
        'schedule_action' => 'Schedule an Appointment',
        'platform' => 'Plataforma',
        'notepad' => 'Shared Notepad', // Context: The shared notepad that appears when votes are needed,
        'appointment_info' => 'Appointment Information',
        'ip_info' => 'IP Address Information for'
    ],


    // ============== HOMEPAGE MESSAGES ======================

    'home' => 'Início',
    'homepagetxt' => 'Página Inicial',
    'login' => 'Iniciar sessão',
    'logout' => 'Terminar sessão',
    'register' => 'Inscreva-se',
    'dashboard' => 'Painel de controlo',
    'back' => 'Retroceder',
    'homepage_welcome' => 'Bem-vindo ao nosso centro de gestão de equipas!',
    'homepage_explainer_line1' => 'Aqui, você pode candidatar-se a cargos abertos, ver o estado da sua candidatura, e gerir o seu perfil.',
    'homepage_explainer_line2' => 'Registe-se com o E-mail para continuar.',
    'footer_copy' => 'Todos os direitos reservados',
    'global_error' => 'Ocorreu um erro',
    'global_success' => 'Sucesso!',
    'txt_learn_more' => 'Mais informações',
    'opening_nodetails' => 'Parecem não haver detalhes',
    'opening_nodetails_exp' => 'Esta candidatura ainda não tem detalhes.',
    'details_m_title' => 'Detalhes da Candidatura',
    'open_positions' => 'Vagas Abertas',
    'last_updated' => 'Última atualização',
    'open_position_count' => '{1} Há :count vaga aberta!|[2,*] Há :count vagas abertas!',
    'ineligible_days_remaining' => 'Não elegível (:days) dia(s) restantes',
    'txt_apply' => 'Candidatar-se', // Context: Apply as in applying for a "job", e.g. registering for a job
    'txt_application' => 'Candidatura',
    'application_closed' => 'Candidaturas Fechadas',
    'application_closed_intro' => 'Olá!',
    'application_closed_intro_line2' => '
      Atualmente não estamos contratando nenhum novo membro da equipa no momento. Se você quiser se candidatar, confira o canal de anúncios
      do Discord para saber quando abre uma nova vaga.
      Nosso ciclo de candidaturas geralmente dura duas semanas, então se você está vendo isso, é porque ela terminou, e um novo começará em breve.
    ',
    'where_work' => 'Onde você trabalhará',
    'join_team' => 'Junte-se à equipa',
    'join_team_cta' => 'Junte-se hoje à equipa e ajude a rede a crescer e prosperar!',
    'contact_cta' => 'Alguma pergunta? Deixe uma mensagem!',
    'contact_disclaimer' => '*Este não é um formulário de candidatura. Qualquer candidatura enviada aqui será ignorada.',
    'contactlabel_name' => 'Nome',
    'contactlabel_email' => 'E-mail',
    'contactlabel_subject' => 'Assunto (ex. sugestão do site)',
    'contactlabel_send' => 'Enviar',



    // ======================== AUTHENTICATION MESSAGES ===========================

    '2fa_txt' => 'Autenticação de dois Fatores',
    '2fa_sronly' => 'Código secreto de dois fatores (Poderá encontrar isso no Google Authenticator)',
    '2fa_lostcode' => 'Não sabe o código?',
    '2fa_cancel_login' => 'Cancelar login (sair)',

    'terms' => 'Condições de Utilização',
    'ppolicy' => 'Política de privacidade',

    'signin_cta' => 'Entrar na sua conta',
    'password' => 'Palavra-passe',
    'remember_me' => 'Lembrar-me',
    'forgot_pw' => 'Esqueceu-se da palavra-passe?',
    'register_cta' => 'Registe-se aqui',
    'no_acc' => 'Não tem uma conta?',
    'register_acc' => 'Registar nova conta',
    'pwsec' => [
        'line1' => 'Verificar a segurança da password',
        'line2' => 'Para sua segurança, implementamos políticas de palavra-passe rigorosas. Também é aconselhável deixar o seu gestor de senhas ou o navegador gerar e salvar senhas para você (se for um dispositivo privado).',
        'line3' => 'As senhas devem ser uma combinação de: ',
        'line4' => 'Um mínimo de 10 caracteres;',
        'line5' => 'Pelo menos 3 caracteres maiúsculos;',
        'line6' => 'Pelo menos 3 números;',
        'line7' => 'Números e caracteres especiais.'
    ],
    'sronly_confirmpassword' => 'Confirmar palavra-passe', // hint: sronly stands for screen-reader only
    'sronly_mcusername' => 'Utilizador do Minecraft (Premium)',
    'have_account' => 'Já tem uma conta?',
    'login_here' => 'Inicie sessão aqui',
    'register_txt' => 'Registe-se',

    // ===================== DASHBOARD & COMPONENT MESSAGES ===========================

    'modal_close' => 'Fechar',
    'component_nopermission' => 'Não tem permissões para aceder a este recurso.',
    'component_accessdenied' => 'Acesso negado',
    'component_contact' => 'Por favor, entre em contacto com seu administrador se acredita que isso foi um erro.',
    'welcome_back' => 'Bem-vindo de volta,',
    'eligible' => 'Qualificado',
    'ineligible' => 'Não elegível',
    'eligibility_status' => 'Seu atual estado de elegibilidade: :badgeStatus',
    'ongoing_apps' => 'Candidaturas a decorrer',
    'denied_apps' => 'Candidaturas negadas',
    'users_staff' => 'Utilizadores totais + Equipa',
    'new_apps' => 'Novas Candidaturas',
    'v_backlog' => 'Votos em atraso',
    'ranks' => 'Cargos disponíveis',
    'open' => 'Abrir',
    'closed' => 'Fechada',
    'upcoming' => 'As suas próximas entrevistas',
    'soon' => 'Disponível em breve',


    //=================== ADMINISTRATION MESSAGES (for all administration pages) ===============

    'adm' => 'Administração',
    'devtools' => 'Ferramentas de Programador',
    'devoptions' => 'Opções de Desenvolvedor',
    'forceeval' => 'Por favor, escolha uma candidatura para forçar reavaliação',
    'appid' => 'ID da candidatura',
    'no_valid_app' => 'Não há candidaturas válidas',
    'choose_app' => 'Escolha uma candidatura',
    'dispatch_event' => 'Enviar evento agora',
    'devtools_warn' => 'Não use estas opções se você não sabe o que está fazendo, mesmo se tiver acesso a esta página.',
    'warn' => 'Atenção',
    'override_votes' => 'Substituir Avaliação do Voto',
    'artisan_evaluate' => 'Artisan: Avaliar Votos Agora', // Tip: Artisan is a program name, therefore not translatable
    'devtools_info' => 'Este painel também pode ser usado para substituir completamente o sistema de votação em cenários de impasse',


    'forms' => 'Formulários',
    'positions' => 'Vagas', // Context: Positions as in job opening
    'edit_form' => 'Editar Formulário',
    'edt' => 'Editor',
    'edit' => 'Editar',
    'edt_action' => 'Editando',
    'txtbox' => 'Caixa de texto',
    'multiline' => 'Múltipla resposta',
    'checkbox' => 'Caixa de verificação',
    'field_type' => 'Selecione um Tipo de Campo',
    'save_exit' => 'Guardar e Sair',
    'new_field' => 'Novo Campo',
    'vacancy_edit' => 'Editor de vagas',
    'new_vacancy' => 'Nova vaga',
    'form_consistency' => 'Para fins de consistência, campos acinzentados não podem ser editados.',

    'vacancy' => [
        'add' => 'Adicionar vaga',
        'name' => 'Nome da vaga',
        'description' => 'Descrição da vaga',
        'details' => 'Detalhes da vaga',
        'markdown' => 'Markdown suportado',
        'no_details' => 'Sem detalhes ainda... Adicione alguns!',
        'permission_group' => 'Grupos de Permissão',
        'permission_group_tooltip' => 'O grupo de permissões do seu servidor/rede. Compatível com a Luckperms e PEX.',
        'discord_roleid' => 'ID do cargo Discord',
        'discord_roleid_tooltip' => 'Discord Desktop: Vá para as configurações da sua conta > Aparência -> Avançado e ative o Modo Desenvolvedor. Na página de cargos do seu servidor, clique com o botão direito de qualquer cargo para copiar o ID.',
        'current_form' => 'Formulário atual (não editável)',
        'remaining_slots' => 'Espaços restantes',
        'free_slots' => 'Espaços livres',
        'free_slots_tooltip' => 'Quantas submissões antes que a vaga pare de aceitar novos candidatos?',
        'save' => 'Guardar Alterações',
        'cancel' => 'Cancelar',
        'close_vacancy' => 'Fechar vaga',
        'description_tooltip' => 'Adicione coisas como requisitos de admissão, responsabilidades e funções, e qualquer outra coisa que você ache necessária',
        ''

    ],

    'form' => 'Formulário',

    'form_builder' => [
        'builder' => 'Construtor de Formulários',
        'builder_name' => 'Ferramenta de Gestão de Formulários de Candidatura',
        'name_form' => 'Nomeie o seu formulário...',
        'save_form' => 'Guardar Formulário',
    ],

    'form_preview' => [
        'preview' => 'Pré-visualizar',
        'title' => 'Pré-visualização do Formulário de Candidatura',
        'looks' => 'É assim que o seu formulário aparece para os candidatos',
        'f_info' => 'Você pode editá-lo e adicionar mais campos posteriormente.',
        ''
    ],

    'forms_p' => [

        'available_forms' => 'Formulários disponíveis',
        'form_title' => 'Título do Formulário',
        'empty_noforms' => 'Nada para ver aqui! Por favor, crie alguns formulários primeiro.',
        'new_form' => 'NOVO FORMULÁRIO'
    ],

    'players' => [

        'reg_players' => 'Jogadores registados',
        'reg_players_staff' => 'Ver Jogadores Registados (Grupo de Candidatos)',
        'total_banned' => 'Total de jogadores banidos',
        'search' => 'Procurar jogadores',
        'f_p_search' => 'Pesquisa de e-mail completa/parcial',
        'p_disclaimer' => 'Atenção: Esta lista inclui apenas jogadores registados no portal de gestão de equipa. Numa versão futura, todos os jogadores da rede serão mostrados aqui.',
        'listing' => 'Lista de jogadores',
        'reg_date' => 'Data de registo',
        'ign' => 'IGN', // Context: Short for In-Game Name
        'banned' => 'Banido',
        'active' => 'Ativo',
        'no_reg' => 'Não há jogadores inscritos!',
        'no_reg_exp' => "
          Jogadores registados são aqueles que não possuem uma função administrativa no aplicativo de gestão de equipa.
          Pode haver outros utilizadores registados na plataforma, mas eles não serão exibidos aqui.
",
        'see_staff' => 'Ver Membros da Equipa'

    ],

    'positions_p' => [

        'application_form' => 'Formulário de Candidatura',
        'select_form' => 'Selecione um formulário...',
        'no_form_error' => "
           Não pode criar uma vaga sem qualquer formulário cujos quais as pessoas se poderiam candidatar.
           Crie um formulário primeiro, e depois crie uma vaga.
           Um único formulário pode ter várias vagas, para que possa anexar futuras vagas ao mesmo formulário, se quiser.
",
        'new_pos' => 'NOVA VAGA',
        'empty_pos_warning' => 'Nada para ver aqui! Abra algumas vagas primeiro. Isso fará os candidatos aparecerem! (esperançoso)',
        'manage_forms' => 'GERIR FORMULÁRIOS DE CANDIDATURA',

    ],

    'settings' => [

        'settings' => 'Definições',
        'settings_header' => 'Configuração das notificações',
        'settings_p' => 'Altere quais notificações são enviadas aqui.',
        'back_btn' => 'Voltar ao painel'

    ],

    'staff' => [

        'members' => 'Membros da Equipa',
        'active_sm' => 'Membros Ativos da Equipa',
        'm_listing' => 'Lista de Membros',
        'f_name' => 'Nome completo',
        'rank' => 'Cargo',
    ],

    // ======================== APPLICATION RENDERING MESSAGES =========================

    'application_r' => [

        'appl_submit_warn' => 'Tem certeza de que deseja enviar a sua candidatura? Por favor, analise cada uma das suas respostas cuidadosamente antes de enviá-la.',
        'appl_submit_doublewarn' => 'Por favor, note: Candidaturas NÃO PODEM serem modificadas assim que forem enviadas!',
        'acceptsend' => 'Aceitar e Enviar',
        'review' => 'Rever',
        'applying_for' => 'Você está se candidatando para: :name',
        'welcome' => [
            'yrs_old' => 'Anos de idade', // Context: "years old" as in: Tom is 24 years old
            'line1' => 'Estamos felizes que você decidiu se candidatar. Geralmente, as candidaturas levam 48 horas para serem processadas e revisadas. Dependendo das circunstâncias e do volume de candidaturas, você poderá receber uma resposta em um período mais curto de tempo.',
            'line2' => 'Por favor, preencha o formulário abaixo. Mantenha todas as respostas concisas e completas. Lembre-se de que o requisito de idade é de pelo menos :agerqr.',
            'line3' => 'Perguntar sobre a sua candidatura resultará em ser negado instantaneamente. Tudo o que você precisa saber está aqui.'
        ],
        'app_timeout' => 'A sua conta não pode enviar outra candidatura. Por favor, espere :days mais dias antes de tentar enviar uma candidatura.'
    ],


    'application_m' => [
        'title' => 'Gestão de Candidaturas',
        'all_apps' => 'Todas as Candidaturas',
        'modal_confirm' => 'Tem a certeza?',
        'really_delete' => 'Deseja realmente excluir isto?',


        'outstanding_sm' => 'Pendente',
        'outstanding_apps' => 'Candidaturas Pendendes',
        'outstanding_subm' => 'Pendente (Enviado)',

        'interview_q' => 'Fila de entrevistas',
        'interview_p' => 'Entrevista',
        'interview_s' => 'Entrevista Agendada',
        'finished_int' => 'Entrevistas concluídas',
        'schedule_int' => 'Agendar Entrevistas',
        'p_review' => 'Revisão por pares',
        'applicant' => 'Candidato',
        'interviewee' => 'Entrevistado',
        'pending_int' => 'Entrevista Pendente',
        'schedule' => 'Agendar',

        'view_interview_queue' => 'Ver fila de entrevistas',
        'view_approval_queue' => 'Ver Fila de Aprovação por Pares',
        'view_outstanding_queue' => 'Visualizar fila de pendentes',

        'approved' => 'Aprovado',
        'denied' => 'Recusado',
        'unknown_stat' => 'Desconhecido',

        'consequence_irreversible' => 'IRREVERSÍVEL',
        'delete_action_warning' => 'Esta ação é :consequence.',
        'delete_explainer' => 'Comentários, compromissos e quaisquer votos anexados a esta candidatura também serão excluídos. Por favor, certifique-se de que esta candidatura realmente precisa ser excluída.',

        'all_apps_header' => 'Você está a ver todas as candidaturas recebidas',
        'all_apps_exp' => 'Aqui, você tem acesso rápido e fácil a todas as candidaturas recebidos pelo sistema.',

        'no_apps' => 'Não há candidaturas aqui',
        'no_apps_exp' => 'Não conseguimos encontrar nenhuma candidatura. Talvez ninguém se inscreveu ainda? Por favor, tente novamente mais tarde.',
        'int_applications' => 'Candidaturas',

        'no_apps_pending_int' => 'Nenhuma candidatura pendente de entrevista',
        'no_apps_pending_int_exp' => 'Não há aplicativos que tenham sido movidos para a fase de Entrevistas. Verifique a fila pendente. Aqui não há aplicativos que tenham sido movidos para a fase de Entrevistas. Por favor, verifique a fila pendente.',
        'upcoming_int' => 'Minhas próximas entrevistas',
        'pending_schedule' => 'Agendamento pendente',

        'no_upcoming' => 'Não há próximas entrevistas',
        'no_upcoming_exp' => 'Por favor, verifique outras filas no processo de candidatura. Os candidatos aqui podem já ter sido entrevistados.',

        'no_outstanding' => 'Não está vendo candidaturas? Verifique com um administrador para certificar-se de que existem posições abertas.',
        'no_outstanding_exp' => 'É também uma boa ideia a publicidade em fóruns relevantes para este fim.',

        'applicant_name' => 'Nome do Candidato',
        'application_date' => 'Data de Inscrição',

        'no_pending' => 'Não existem candidaturas pendente',
        'no_pending_exp' => 'Parece que ninguém novo se candidatou ainda. Confira as filas de entrevista e aprovação para candidaturas que podem ter movido fases até agora.',

        'voting_reminder' => [

            'title' => 'Lembrete de votação',
            'line1' => 'Candidaturas que obtêm mais de 50% dos votos positivos são automaticamente aprovadas após um dia.',
            'line2' => 'Inversamente, candidaturas que não atingem esse número são automaticamente negadas.',
            'line3' => 'Por favor, lembre-se que o sistema de votação pode ser substituído'

        ],

        'no_pending_review' => 'Não há candidaturas pendentes de entrevista',
        'no_pending_review_exp' => 'Verifique as outras filas para ver mais candidaturas! As candidaturas serão mostradas aqui assim que as suas entrevistas forem concluídas. Poderá ver notas da reunião e votar baseando-se nas suas observações.',

    ],

    // ============= PROFILE & USER MESSAGES ===============

    'profile' => [

        'title' => 'Perfil de :name',
        'profile' => 'Perfil',
        'users' => 'Utilizadores',
        'account_banned' => 'Conta banida',
        'account_banned_exp' => 'Este utilizador foi banido pelos moderadores.',
        'ban_confirm' => 'Por favor, confirme que você deseja banir este utilizador. Você precisará adicionar um motivo e uma data de expiração para confirmar isto. Banimentos não transferem para redes de Minecraft conectadas (ainda).',
        'leave_empty' => 'Deixe em branco para um banimento permanente',
        'duration' => 'Duração',
        'p_duration' => 'Duração da penalização',
        'p_duration_exp' => 'por exemplo, spam',
        'ban' => 'Banir',

        'terminate_notice' => 'Você está prestes a excluir um membro da equipa',
        'terminate_notice_warning' => 'Excluir um membro da equipa irá remover os respetivos privilégios do site de gestão da equipa e da Rede.
                Eles serão notificados sobre o cancelamento. Certifique-se de que já tenha discutido isto com eles.',
        'terminate_notice_consequence' => 'ESTE PROCESSO É IRREVERSÍVEL E IMEDIATO',
        'terminate_txt' => 'Apagar membro da equipa',

        'delete_acc_warn' => 'AVISO: Esta é uma ação potencialmente destrutiva!',
        'delete_acc_consequence' => 'Excluir uma conta de utilizador é um processo irreversível. Candidaturas históricas e atuais, votos e conteúdo do perfil, bem como qualquer informação que seja pessoalmente identificável serão imediatamente apagados.',
        'type_to_confirm' => 'Digite para confirmar:',
        'type_placeholder' => 'Digite o valor acima',

        'delete_acc' => 'Apagar conta',
        'edit_acc' => 'Editar Conta',

        'ban_acc' => 'Banir conta',
        'unban_acc' => 'Desbloquar conta',

        'search_result' => 'Resultados da pesquisa',

        'origin_cc' => 'País de origem',
        'state_prov' => 'Estado/Província',
        'district' => 'Distrito (se houver)',
        'city' => 'Cidade',
        'zipcode' => 'Código postal',
        'coords' => 'Coordenadas',
        'european' => 'Europeu?',
        'isp' => 'Provedor', // Internet service provider
        'org' => 'Organização (se houver)',
        'ctype' => 'T. de Ligação', // Internet Connection type
        'timezone' => 'Fuso horário',
        'noresults' => 'A sua pesquisa não retornou resultados.',

        'edituser' => 'Editar dados pessoais e cargos', // PII: Personally identifiable information
        'edituser_consequence' => 'Aviso! Esta é uma configuração sensível! Mudar isto pode ter consequências não intencionais!',
        'acc_management' => 'Gestão de conta (administrador)',
        'discord_tag' => 'Tag do Discord: :discordTag',
        'account_settings' => 'Definições de Conta',
        'account_settings_personal' => 'Minhas Configurações de Conta',

        '2fa_welcome' => 'Estamos felizes por você ter decidido aumentar a segurança de sua conta!',
        'supported_apps' => 'Aplicativos suportados que você pode instalar: ',
        'scan_code' => 'Leia o código :scannable com o seu aplicativo preferido e copie o código aqui.',
        'otp' => 'Código de uso único',
        '2fa_enable' => 'Ativar 2FA',
        '2fa_remove_consequence' => 'Remover a autenticação de dois fatores reduzirá a segurança de sua conta.',
        '2fa_password_confirm' => 'Confirme a sua palavra-passe para continuar',
        '2fa_password_confirm_exp' => 'Para impedir alterações não autorizadas, uma senha é sempre necessária para operações confidenciais.',
        '2fa_disable_consent' => '"Eu compreendo as possíveis consequências de desativar a autenticação de dois fatores"',
        '2fa_remove' => 'Remover 2FA',
        '2fa_remove_extended' => 'Remove Two-Factor Authentication',

        'security_lgotherdev' => 'Para sua segurança, você precisará re-introduzir a sua senha antes de desconectar outros dispositivos. Se você acredita que sua conta foi comprometida, altere sua senha em vez disso, já que isso desconectará automaticamente qualquer pessoa que poderá estar usando sua conta e impedir que faça login novamente.',
        'password_reenter' => 'Repita a sua palavra-passe',

        'acc_security' => 'Segurança da conta',
        '2fa' => 'Autenticação de dois Fatores',
        'sessions' => 'Sessões',
        'contact_settings' => 'Configurações de Contacto (E-Mail)',

        'change_password' => 'Alterar palavra-passe',
        'change_password_exp' => 'Altere sua senha aqui. Isto desconectará você de todas as sessões existentes para sua segurança.',

        'old_pass' => 'Palavra-passe antiga',
        'forgot_pw' => 'Esqueceu sua senha? Reponha-a :link',
        'new_pw' => 'Nova palavra-passe',

        '2fa_enable_success' => 'Fixe! A 2FA está configurada corretamente para a sua conta. Será solicitado um código toda vez que você fizer login.',
        '2fa_avail' => 'A autenticação de dois fatores está disponível para sua conta.',
        '2fa_avail_exp' => ' Habilitar esta opção de segurança aumenta consideravelmente a segurança da sua conta caso a sua senha seja roubada.',

        'session_manager' => 'Gestor de Sessões',
        'terminate_others' => 'Terminar outras sessões é geralmente uma boa ideia se sua conta foi comprometida.',
        'current_session' => 'Sua sessão atual: conectado a partir de :ipAddress',
        'flush_session' => 'Limpar sessões',
        'personal_data_change' => 'Precisa alterar dados pessoais? Você pode fazer isso aqui.',
        'current_email' => 'Endereço de e-mail atual',
        'new_email' => 'Novo endereço de e-mail',
        'current_password' => 'Palavra-passe Atual',
        'security_nochangepw' => 'Por motivos de segurança, você não pode fazer alterações de conta importantes sem confirmar a sua senha. Você também precisará confirmar o seu novo e-mail.',
        'change_email' => 'Alterar Endereço de Email',

        'basic_info' => 'Informações básicas',
        'fl_name' => 'Primeiro e último nome',
        'shortbio' => 'Pequena biografia',
        'about_me' => 'Sobre mim',
        'pref_media' => 'Preferências & Média',
        'avatar_source' => 'Obter o avatar de: ',
        'social_media' => 'Redes Sociais',

        'github_user' => 'Utilizador GitHub',
        'twitter_user' => 'Utilizador no Twitter',
        'insta_user' => 'Nome de Utilizador do Instagram',
        'discord_user' => '"Handle" do Discord',

        'update_prfl' => 'Atualizar Perfil'

    ],

    // ==================== USER ACCOUNT MESSAGES (NON-PRIVILEGED) =====================

    'user' => [

        'app_process' => [
            'title' => 'Processo de Candidatura',
            'line1' => 'Por favor, aguarde pelo menos três dias para que sua candidatura seja processada. A inscrição será revisada por todos os membros da equipa, e será promovida em fases.',
            'line2' => 'Se uma entrevista estiver programada, você precisará abrir o aplicativo aqui e confirmar a hora, data e local atribuídos para você.'
        ],

        'account_standing' => 'Estado da Conta',
        'account_eligibility' => 'Sua conta está atualmente :eligibility para candidatura',
        'days_remaining_acc_alt' => 'A partir de hoje, há :days restantes até que você tenha permissão para enviar outra candidatura.',
        'my_ongoingapps' => 'Minhas Candidaturas em Andamento',

        'submitted' => 'Enviado',
        'peer_approval' => 'Aprovação em Pares',
        'peer_approval_q' => 'Fila de Aprovação por Pares',

        'nothing_to_show' => 'Nada a exibir',
        'nothing_to_show_exp' => 'Você atualmente não tem nenhuma candidatura para exibir. Se você é elegível, você pode-se candidatar uma vez por mês.',

        'directory' => [

            'itsyou' => 'É você!',
            'title' => 'Diretório de Utilizadores',
            'directory' => 'Diretório'

        ]

    ],

    'view_app' => [

        'title' => 'Vendo candidatura',
        'viewing_app' => 'Visualizando a candidatura de :user',
        'cantvote' => 'Não pode votar nesta candidatura novamente.',
        'no_notes' => 'Ainda não há notas. Adicione algumas!',
        'deny_confirm' => 'Tem certeza que deseja negar esta candidatura? Por favor, tenha em mente que este utilizador só terá permissão para se candidatar 30 dias após sua primeira candidatura.',
        'deny_confirm_consequence' => 'Esta ação não pode ser desfeita.',
        'deny_confirm_btn' => 'Confirmar: Negar candidato',
        'form_updated_alert' => 'Se este formulário foi atualizado, novos campos e perguntas atualizadas não aparecerão aqui!',
        'context_info' => 'Informações contextuais',
        'appl_ip' => 'Endereço IP do candidato',
        'appl_for' => 'Candidatando-se a',
        'currentstatus' => 'Estado atual',
        'decisionmod' => 'Ferramentas de Decisão & Moderação',
        'denyapp' => 'Recusar candidato',
        'nextstage' => 'Mover para a próxima fase',
        'appointment_desc' => 'Descrição do agendamento',
        'int_date_time' => 'Data e Hora da Entrevista',
        'choosedate' => 'Clique para escolher uma data',
        'appointment_loc' => 'Local do Agendamento',
        'pref_platform' => 'Selecione sua plataforma preferida',
        'coming_soon_int' => 'Videoconferência interna em breve, suportada por Jitsi Meet',
        'scheduled_for' => 'Entrevista Agendada para:',
        'platform' => 'Plataforma',
        'finish_meeting' => 'Finalizar reunião',
        'view_notes' => 'Notas da Reunião',
        'vote_app' => 'Votar nesta candidatura',

        'vote_explainer' => [

            'line1' => 'Se você não estava presente durante esta reunião, pode visualizar o bloco de notas da reunião partilhado para ajudá-lo a tomar uma decisão.',
            'line2' => 'Você pode votar em quantas candidaturas forem necessárias; no entanto, só pode votar uma vez por candidatura.',
            'line3' => 'Os votos não têm peso baseado no cargo. Esse sistema foi projetado com justiça e facilidade de uso em mente.'

        ],

        'vote_approve' => 'Voto: Aprovar o candidato',
        'vote_deny' => 'Voto: Negar o candidato',
        'm_notes' => 'Notas da Reunião',
        'view_more' => 'Ver mais candidaturas',
        'comments' => 'Comentários',
        'no_comments' => 'Ainda não há comentários.',
        'no_comments_exp' => 'Não há comentários aqui! Comentários só são visíveis para os membros da equipa. Seja o primeiro a partilhar a sua opinião! Comentar pode ajudar na tomada de decisões quando chegar o momento de votar na candidatura.',
        'commenting_as' => 'Comentando como :username',
        'max_chars' => 'caracteres no máximo', // Context: A number is added before max characters
        'post' => 'Publicar', // Context: Post as in post comment

    ]

    // ==================== END OF MAIN I18N FILE ======================

];
