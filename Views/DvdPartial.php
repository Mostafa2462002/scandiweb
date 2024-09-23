<?php echo '<div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-4">
            <div class="card" style="background-color:#f4e1c1">
                <input type="checkbox" class="delete-checkbox mt-5" name="' . $item['sku'] . '">
                <div class="card-body d-flex flex-column p-3 m-3 align-items-center">
                    <h5 class="card-title">SKU: ' .$item['sku'] . '</h5>
                    <strong><div class="card-title">Name: ' . $item['name'] . '</strong></div>
                    <div class="card-text">Price: ' . $item['price'] . '$' . '</div>
                    <div class="card-text">' . 'size' . ': ' . $item['size'].' MB' . '</div>
                </div>
            </div>
        </div>';
        ?>