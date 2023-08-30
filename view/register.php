<p>formulaire d'inscription :</p>
<form action="index.php?ctrl=security&action=register" method="post">
    <label for="pseudo">Pseudonyme : *</label>
    <input type=text name="pseudo" required>
    <label for="email">E-mail : *</label>
    <input type="email" name="email" required>
    <label for="mdp">Mot de passe : *</label>
    <input type="password" name="mdp" required>
    <label for="mdpCheck">Confirmer le mot de passe : *</label>
    <input type="password" name="mdpCheck" required>
    <button type="submit" name="submit">S'inscrire</button>
</form>