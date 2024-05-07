<?php $params = ['last', 'search']; ?>

<div class="row d-flex justify-content-center">
    <div class="buttons">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $current_page > 1 ? $current_page - 1 : $current_page; ?><?= checkParams($params); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>

                <?php for ($i = 1; $i < $pages + 1; $i++) : ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $i; ?><?= checkParams($params); ?>"><?= $i; ?></a></li>
                <?php endfor; ?>

                <li class="page-item">
                    <a class="page-link" href="?page=<?= $pages > $current_page ? $current_page + 1 : $current_page; ?><?= checkParams($params); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>