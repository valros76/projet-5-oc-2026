document.addEventListener('DOMContentLoaded', function () {
  cookieconsent.run({
    "notice_banner_type": "headline",
    "consent_type": "express",
    "palette": "light",
    "language": "fr",
    "page_load_consent_levels": ["strictly-necessary", "tracking"],
    "notice_banner_reject_button_hide": false,
    "preferences_center_close_button_hide": false, "page_refresh_confirmation_buttons": false,
    "website_name": "Webdevoo",
    "website_privacy_policy_url": "https://webdevoo.com/rgpd",
    "callbacks": {
      "scripts_specific_loaded": (level) => {
        switch (level) {
          case 'tracking':
            gtag('consent', 'update', {
              'ad_storage': 'granted',
              'ad_user_data': 'granted',
              'ad_personalization': 'granted',
              'analytics_storage': 'granted'
            });
            break;
        }
      }
    },
    "callbacks_force": true
  });
});