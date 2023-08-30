<p>formulaire de connexion :</p>
<form action="index.php?ctrl=security&action=login" method="post">
    <label for="email">E-mail : *</label>
    <input type="email" name="email" required>
    <label for="mdp">Mot de passe : *</label>
    <input type="password" name="mdp" required>
    <button type="submit" name="submit">Se connecter</button>
</form>