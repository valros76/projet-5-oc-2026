# Lancement des tests unitaires
- Clonez le projet complet ou récupérez uniquement le dossier `/api`
- Activez l'extension `pdo_sqlite`, dans `php.ini`
- Ouvrez un terminal sur `/api`
- Exécutez la commande suivante pour lancer les tests unitaires
```bash
./vendor/bin/phpunit tests --testdox
```

## Lancement du serveur
- Assurez-vous d'avoir PHP d'installé sur votre machine (V8.5.5 lors du développement)
- Lancez la commande suivante pour lancer le serveur local :
```bash
php -S 127.0.0.1:5500
```