// obtain plugin
var cc = initCookieConsent();
var current_lang = document.documentElement.lang.split('-')[0];

// run plugin with your configuration
cc.run({
	autorun: true,
	current_lang: current_lang,
	autoclear_cookies: true,
	page_scripts: true,
	cookie_expiration: 182, // days
	onFirstAction: function(user_preferences, cookie) {
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({
			'event': 'consent_mode_update',
			'categories': cookie.categories
		});
	},
	onChange: function(cookie, changed_categories) {
		// cookie.categories.includes("analytics")
		window.dataLayer = window.dataLayer || [];
		window.dataLayer.push({
			'event': 'consent_mode_update',
			'categories': cookie.categories
		});
	},
	languages: {
		'nl': {
			consent_modal: {
				title: 'We gebruiken cookies',
				description: 'Deze website gebruikt cookies om u de beste ervaring te bieden. <button type="button" data-cc="c-settings" class="cc-link">Cookies beheren</button><p>Hoe worden deze cookies gebruikt en opgeslaan? <a href="https://jazz.legal/cookie-verklaring/">Lees Cookie verklaring</a></p>',
				primary_btn: {
					text: 'Accepteren',
					role: 'accept_all'
				},
				secondary_btn: {
					text: 'Weigeren',
					role: 'accept_necessary'
				}
			},
			settings_modal: {
				title: 'Cookie instellingen',
				save_settings_btn: 'Instellingen opslaan',
				accept_all_btn: 'Alles accepteren',
				reject_all_btn: 'Alles weigeren',
				close_btn_label: 'Sluiten',
				cookie_table_headers: [
					{col1: 'Naam'},
					{col2: 'Domein'},
					{col3: 'Duurtijd'}
				],
				blocks: [
					{
						title: 'Cookie gebruik',
						description: 'We gebruiken cookies om de basisfunctionaliteiten van de website te waarborgen en om uw online ervaring te verbeteren. U kunt voor elke categorie kiezen om u aan of af te melden.'
					}, {
						title: 'Essentiële cookies',
						description: 'Deze cookies zijn essentieel voor het goed functioneren van de website.',
						toggle: {
							value: 'necessary',
							enabled: true,
							readonly: true
						}
					}, {
						title: 'Analytische cookies',
						description: 'Deze cookies verzamelen informatie over hoe je de website gebruikt, welke paginas je hebt bezocht en op welke links je hebt geklikt. Alle gegevens zijn geanonimiseerd en kunnen niet worden gebruikt om u te identificeren.',
						toggle: {
							value: 'analytics',
							enabled: false,
							readonly: false
						},
						cookie_table: [
							{
								col1: '^_ga',
								col2: 'google.com',
								col3: '2 jaar',
								is_regex: true
							},
							{
								col1: '^_gat',
								col2: 'google.com',
								col3: '1 minuut',
								is_regex: true
							},
							{
								col1: '^_gid',
								col2: 'google.com',
								col3: '1 dag',
								is_regex: true
							},
							{
								col1: '^_hjSession',
								col2: 'google.com',
								col3: '30 minuten',
								is_regex: true
							},
							{
								col1: '^_pk',
								col2: 'google.com',
								col3: '1 jaar',
								is_regex: true
							},
							{
								col1: '_uetsid',
								col2: 'google.com',
								col3: '1 dag',
								is_regex: false
							},
							{
								col1: '_uetvid',
								col2: 'google.com',
								col3: '1 jaar',
								is_regex: false
							}
						]
					}
				]
			}
		},
		'en': {
			consent_modal: {
				title: 'We use cookies',
				description: 'This website uses cookies to offer you the best experience. <button type="button" data-cc="c-settings" class="cc-link">Manage Cookies</button><p>How are these cookies used and stored? <a href="https://jazz.legal/cookie-verklaring/">Read Cookie Statement</a></p>',
				primary_btn: {
					text: 'Accept all',
					role: 'accept_all'
				},
				secondary_btn: {
					text: 'Decline',
					role: 'accept_necessary'
				}
			},
			settings_modal: {
				title: 'Cookie settings',
				save_settings_btn: 'Save settings',
				accept_all_btn: 'Accept all',
				reject_all_btn: 'Decline',
				close_btn_label: 'Close',
				cookie_table_headers: [
					{col1: 'Name'},
					{col2: 'Domain'},
					{col3: 'Duration'}
				],
				blocks: [
					{
						title: 'Cookie use',
						description: 'We use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose to opt in or out for each category.'
					}, {
						title: 'Essential cookies',
						description: 'These cookies are essential for the proper functioning of the website.',
						toggle: {
							value: 'necessary',
							enabled: true,
							readonly: true
						}
					}, {
						title: 'Analytical cookies',
						description: 'These cookies collect information about how you use the website, which pages you have visited, and which links you have clicked on. All data is anonymized and cannot be used to identify you.',
						toggle: {
							value: 'analytics',
							enabled: false,
							readonly: false
						},
						cookie_table: [
							{
								col1: '^_ga',
								col2: 'google.com',
								col3: '2 year',
								is_regex: true
							},
							{
								col1: '^_gat',
								col2: 'google.com',
								col3: '1 minute',
								is_regex: true
							},
							{
								col1: '^_gid',
								col2: 'google.com',
								col3: '1 day',
								is_regex: true
							},
							{
								col1: '^_hjSession',
								col2: 'google.com',
								col3: '30 minutes',
								is_regex: true
							},
							{
								col1: '^_pk',
								col2: 'google.com',
								col3: '1 year',
								is_regex: true
							},
							{
								col1: '_uetsid',
								col2: 'google.com',
								col3: '1 day',
								is_regex: false
							},
							{
								col1: '_uetvid',
								col2: 'google.com',
								col3: '1 year',
								is_regex: false
							}
						]
					}
				]
			}
		}
	}
});
