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
        'app_settings' => 'Configurações do Aplicativo',
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
        'platform' => 'Plataforma'
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
    'component_contact' => 'Por favor, entre em contato com seu administrador se acredita que isso foi um erro.',
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
    'closed' => 'Closed',
    'upcoming' => 'Your upcoming interviews',
    'soon' => 'Coming soon',


    //=================== ADMINISTRATION MESSAGES (for all administration pages) ===============

    'adm' => 'Administration',
    'devtools' => 'Developer Tools',
    'devoptions' => 'Developer Options',
    'forceeval' => 'Please choose an application to force re-evaluation',
    'appid' => 'Application ID',
    'no_valid_app' => 'There are no valid applications',
    'choose_app' => 'Choose an application',
    'dispatch_event' => 'Dispatch event now',
    'devtools_warn' => 'Do not use these options if you don\'t know what you\'re doing, even if you have access to this page.',
    'warn' => 'Warning',
    'override_votes' => 'Override Vote Evaluation',
    'artisan_evaluate' => 'Artisan: Evaluate Votes Now', // Tip: Artisan is a program name, therefore not translatable
    'devtools_info' => 'This panel may be also used to completely override the vote system in stalemate scenarios',


    'forms' => 'Forms',
    'positions' => 'Positions', // Context: Positions as in job opening
    'edit_form' => 'Edit Form',
    'edt' => 'Editor',
    'edit' => 'Edit',
    'edt_action' => 'Editing',
    'txtbox' => 'Textbox',
    'multiline' => 'Multi line answer',
    'checkbox' => 'Checkbox',
    'field_type' => 'Choose a field type',
    'save_exit' => 'Save & Quit',
    'new_field' => 'New field',
    'vacancy_edit' => 'Vacancy Editor',
    'new_vacancy' => 'New Vacancy',
    'form_consistency' => 'For consistency purposes, grayed out fields can\'t be edited.',

    'vacancy' => [
        'add' => 'Add vacancy',
        'name' => 'Vacancy Name',
        'description' => 'Vacancy Description',
        'details' => 'Vacancy Details',
        'markdown' => 'Markdown Supported',
        'no_details' => 'No details yet... Add some!',
        'permission_group' => 'Permission Group',
        'permission_group_tooltip' => 'The permission group from your server/network\'s permissions manager. Compatible with Luckperms and PEX.',
        'discord_roleid' => 'Discord Role ID',
        'discord_roleid_tooltip' => 'Discord Desktop: Go to your Account Settings > Appearance -> Advanced and toggle Developer Mode. On your server\'s roles tab, right click any role to copy it\'s ID.',
        'current_form' => 'Current Form (uneditable)',
        'remaining_slots' => 'Remaining slots',
        'free_slots' => 'Free slots',
        'free_slots_tooltip' => 'How many submissions before the vacancy stops accepting new applicants?',
        'save' => 'Save Changes',
        'cancel' => 'Cancel',
        'close_vacancy' => 'Close Position',
        'description_tooltip' => 'Add things like admission requirements, rank resposibilities and roles, and anything else you feel is necessary',
        ''

    ],

    'form' => 'Form',

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
        'reg_players_staff' => 'Ver Jogadores Registrados (Grupo de Candidatos)',
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
          Jogadores registrados são aqueles que não possuem uma função administrativa no aplicativo de gestão de equipa.
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
        'app_timeout' => 'Your account is not permitted to submit another application. Please wait :days more days before trying to submit an application.'
    ],


    'application_m' => [
        'title' => 'Application Management',
        'all_apps' => 'All Applications',
        'modal_confirm' => 'Are you sure?',
        'really_delete' => 'Really delete this?',


        'outstanding_sm' => 'Outstanding',
        'outstanding_apps' => 'Outstanding Applications',
        'outstanding_subm' => 'Outstanding (Submitted)',

        'interview_q' => 'Interview Queue',
        'interview_p' => 'Interview',
        'interview_s' => 'Interview Scheduled',
        'finished_int' => 'Finished Interviews',
        'schedule_int' => 'Schedule Interviews',
        'p_review' => 'Peer Review',
        'applicant' => 'Applicant',
        'interviewee' => 'Interviewee',
        'pending_int' => 'Pending Interview',
        'schedule' => 'Schedule',

        'view_interview_queue' => 'View Interview Queue',
        'view_approval_queue' => 'View Approval Queue',
        'view_outstanding_queue' => 'View Outstanding Queue',

        'approved' => 'Approved',
        'denied' => 'Denied',
        'unknown_stat' => 'Unknown',

        'consequence_irreversible' => 'IRREVERSIBLE',
        'delete_action_warning' => 'This action is :consequence.',
        'delete_explainer' => 'Comments, appointments and any votes attached to this application WILL be deleted too. Please make sure this application really needs to be deleted.',

        'all_apps_header' => 'You\'re looking at all applications ever received',
        'all_apps_exp' => 'Here, you have quick and easy access to all applications ever received by the system.',

        'no_apps' => 'There are no applications here',
        'no_apps_exp' => 'We couldn\'t find any applications. Maybe no one has applied yet? Please try again later.',
        'int_applications' => 'Applications',

        'no_apps_pending_int' => 'No Applications Pending Interview',
        'no_apps_pending_int_exp' => 'There are no applications that have been moved up to the Interview stage. Please check the outstanding queue.There are no applications that have been moved up to the Interview stage. Please check the outstanding queue.',
        'upcoming_int' => 'My Upcoming Interviews',
        'pending_schedule' => 'Pending Schedule',

        'no_upcoming' => 'There are no upcoming interviews',
        'no_upcoming_exp' => 'Please check other queues down in the application process. Applicants here may have already been interviewed.',

        'no_outstanding' => 'Seeing no applications? Check with an Administrator to make sure that there are available open positions.',
        'no_outstanding_exp' => 'Advertising on relevant forums made for this purpose is also a good idea.',

        'applicant_name' => 'Applicant Name',
        'application_date' => 'Application Date',

        'no_pending' => 'There are no pending applications',
        'no_pending_exp' => 'It seems like no one new has applied yet. Checkout the interview and approval queues for applications that might have moved up the ladder by now.',

        'voting_reminder' => [

            'title' => 'Voting Reminder',
            'line1' => 'Applications which gain more than 50% of positive votes are automatically approved after one day.',
            'line2' => 'Conversely, applications that do not reach this number are automatically denied.',
            'line3' => 'Please note that the vote system can be overridden'

        ],

        'no_pending_review' => 'There are no applications pending review',
        'no_pending_review_exp' => 'Check the other queues for any applications! Applications will be shown here as soon as their interview is completed. You\'ll be able to view meeting notes and vote based on your observations.',

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
        'unban_acc' => 'Desbanir conta',

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
        'scan_code' => 'Escaneie o código :scannable com o seu aplicativo preferido e copie o código aqui.',
        'otp' => 'Código de uso único',
        '2fa_enable' => 'Ativar 2FA',
        '2fa_remove_consequence' => 'Remover a autenticação de dois fatores reduzirá a segurança de sua conta.',
        '2fa_password_confirm' => 'Confirme a sua palavra-passe para continuar',
        '2fa_password_confirm_exp' => 'Para impedir alterações não autorizadas, uma senha é sempre necessária para operações confidenciais.',
        '2fa_disable_consent' => '"I understand the possible consequences of disabling two factor authentication"',
        '2fa_remove' => 'Remove 2FA',

        'security_lgotherdev' => 'For your security, you\'ll need to re-enter your password before logging out other devices. If you believe your account has been compromised, please change your password instead, as that will automatically log out anyone else who might using your account, and prevent them from signing back in.',
        'password_reenter' => 'Re-enter your password',

        'acc_security' => 'Account Security',
        '2fa' => 'Two Factor Authentication',
        'sessions' => 'Sessions',
        'contact_settings' => 'Contact Settings (E-Mail)',

        'change_password' => 'Change Password',
        'change_password_exp' => 'Change your password here. This will log you out from all existing sessions for your security.',

        'old_pass' => 'Old Password',
        'forgot_pw' => 'Forgot your password? Reset it :link',
        'new_pw' => 'New Password',

        '2fa_enable_success' => 'Hooray! 2FA is setup correctly for your account. A code will be asked each time you login.',
        '2fa_avail' => 'Two-factor auth is available for your account.',
        '2fa_avail_exp' => ' Enabling this security option greatly increases your account\'s security in case your password ever gets stolen.',

        'session_manager' => 'Session Manager',
        'terminate_others' => 'Terminating other sessions is generally a good idea if your account has been compromised.',
        'current_session' => 'Your current session: logged in from :ipAddress',
        'flush_session' => 'Flush sessions',
        'personal_data_change' => 'Need to change personal data? You can do so here.',
        'current_email' => 'Current Email Address',
        'new_email' => 'New Email Address',
        'current_password' => 'Current Password',
        'security_nochangepw' => 'For security reasons, you cannot make important account changes without confirming your password. You\'ll also need to verify your new email.',
        'change_email' => 'Change Email Address',

        'basic_info' => 'Basic Information',
        'fl_name' => 'First / Last Name',
        'shortbio' => 'Short Bio',
        'about_me' => 'About Me',
        'pref_media' => 'Preferences & Media',
        'avatar_source' => 'Retrieve avatar from: ',
        'social_media' => 'Social Media',

        'github_user' => 'Github Username',
        'twitter_user' => 'Twitter Username',
        'insta_user' => 'Instagram Username',
        'discord_user' => 'Discord Handle',

        'update_prfl' => 'Update Profile'

    ],

    // ==================== USER ACCOUNT MESSAGES (NON-PRIVILEGED) =====================

    'user' => [

        'app_process' => [
            'title' => 'Application Process',
            'line1' => 'Please allow up to three days for your application to be processed. Your application will be reviewed by every team member, and will move up in stages.',
            'line2' => 'If an interview is scheduled, you\'ll need to open your application here and confirm the time, date, and location assigned for you.'
        ],

        'account_standing' => 'Account Standing',
        'account_eligibility' => 'Your account is currently :eligibility for application',
        'days_remaining_acc_alt' => 'As of today, there are :days remaining until you\'re permitted to submit another application.',
        'my_ongoingapps' => 'My Ongoing Applications',

        'submitted' => 'Submitted',
        'peer_approval' => 'Peer Approval',
        'peer_approval_q' => 'Peer Approval Queue',

        'nothing_to_show' => 'Nothing to show',
        'nothing_to_show_exp' => 'You currently have no applications to display. If you\'re eligible, you may apply once every month.',

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
        'context_info' => 'Contextual Information',
        'appl_ip' => 'Applicant IP Address',
        'appl_for' => 'Applying for',
        'currentstatus' => 'Current Status',
        'decisionmod' => 'Decision & Moderation Tools',
        'denyapp' => 'Deny applicant',
        'nextstage' => 'Move to next stage',
        'appointment_desc' => 'Appointment description',
        'int_date_time' => 'Interview Date & Time',
        'choosedate' => 'Click to choose a date',
        'appointment_loc' => 'Appointment Location',
        'pref_platform' => 'Select your preferred platform',
        'coming_soon_int' => 'Embedded in-house video conferencing coming soon, powered by Jitsi Meet',
        'scheduled_for' => 'Interview Scheduled for:',
        'platform' => 'Platform',
        'finish_meeting' => 'Finish Meeting',
        'view_notes' => 'View Meeting Notes',
        'vote_app' => 'Vote on this application',

        'vote_explainer' => [

            'line1' => 'If you weren\'t present during this meeting, you can view the shared meeting notepad to help you make a decision.',
            'line2' => 'You may vote on as many applications as needed; However, you can only vote once per application.',
            'line3' => 'Votes carry no weight based on rank. This system has been designed with fairness and ease of use in mind.'

        ],

        'vote_approve' => 'Vote: Approve Applicant',
        'vote_deny' => 'Vote: Deny Applicant',
        'm_notes' => 'Meeting notes',
        'view_more' => 'View more Applications',
        'comments' => 'Comments',
        'no_comments' => 'There are no comments here.',
        'no_comments_exp' => 'There are no comments here! Comments are only visible to staff members. Be the first to share your input! Commenting may help with decision-making when time comes to vote for an application.',
        'commenting_as' => 'Commenting as :username',
        'max_chars' => 'max characters', // Context: A number is added before max characters
        'post' => 'Post', // Context: Post as in post comment

    ]

    // ==================== END OF MAIN I18N FILE ======================

];
