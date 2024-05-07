<?php $params = ['search', 'username']; ?>

<section id="pagination">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=<?= $current_page > 1 ? $current_page - 1 : $current_page; ?><?= checkParams($params); ?>" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            <?php for ($i = 1; $i < $pages + 1; $i++) : ?>
                <li class="page-item"><a class="page-link <?= $current_page == $i ? 'page_active' : '' ?>" href="?page=<?= $i; ?><?= checkParams($params); ?>"><?= $i ?></a></li>
            <?php endfor; ?>

            <li class=" page-item">
                <a class="page-link" href="?page=<?= $pages > $current_page ? $current_page + 1 : $current_page; ?><?= checkParams($params); ?>" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</section>