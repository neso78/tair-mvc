<nav>
    <ul>
        <?php foreach ($radnje as $radnja): ?>
            <li>
                <a href="?radnja=<?php echo urlencode($radnja->id); ?>">
                    <?php echo htmlspecialchars($radnja->naziv); ?><br>
                    <?php echo htmlspecialchars($radnja->adresa); ?><br>
                    <?php echo htmlspecialchars($radnja->telefon); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
