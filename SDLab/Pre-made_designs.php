<!-- Pre-Made Designs -->
<div class="container my-5 pre-made-designs">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>PRE-MADE DESIGNS</h2>
        <a href="Products.php" class="btn btn-link text-dark">SEE ALL →</a>
    </div>

    <div class="row g-3">
        <?php
        // Define the directory where T-shirt images are stored
        $dir = "images/TSHIRTS/";
        
        // Try to get files from directory
        $files = array();
        foreach($fileTypes as $type) {
            $typeFiles = glob($dir . "*." . $type);
            if($typeFiles) {
                $files = array_merge($files, $typeFiles);
            }
        }
        
        // Display up to 3 designs on the homepage
        $maxHomepageDisplays = 3;
        $displayCount = 0;
        
        // Check if we found any real files
        if(count($files) > 0) {
            // Shuffle the array to show random designs on homepage
            shuffle($files);
            
            // Display up to 3 designs
            foreach($files as $file) {
                if($displayCount >= $maxHomepageDisplays) break;
                
                $displayCount++;
                $filename = basename($file);
                // Extract product name from filename (remove extension)
                $productName = pathinfo($filename, PATHINFO_FILENAME);
                $productName = str_replace('_', ' ', $productName);
                $productName = ucwords($productName);
                
                // Generate product ID and price (in a real app these would come from a database)
                $productId = $displayCount;
                $productPrice = "25.99";
        ?>
        <div class="col-md-4">
            <a href="ProductDetail.php?id=<?php echo $productId; ?>&name=<?php echo urlencode($productName); ?>&price=<?php echo $productPrice; ?>" class="text-decoration-none text-dark">
                <div class="design-placeholder">
                    <img src="<?php echo $file; ?>" alt="<?php echo $productName; ?>">
                </div>
                <div class="text-center mt-2">
                    <h4><?php echo $productName; ?></h4>
                </div>
            </a>
        </div>
        <?php
            }
        }
        
        // If no images found or less than 3 images, fill the rest with placeholders
        for($i = $displayCount; $i < $maxHomepageDisplays; $i++) {
            // Generate product ID and price for placeholders
            $productId = $i + 100;
            $productPrice = "25.99";
            $productName = "Sample Design " . ($i+1);
        ?>
        <div class="col-md-4">
            <a href="ProductDetail.php?id=<?php echo $productId; ?>&name=<?php echo urlencode($productName); ?>&price=<?php echo $productPrice; ?>" class="text-decoration-none text-dark">
                <div class="design-placeholder">
                    <img src="/api/placeholder/450/450?text=No+Image" alt="Design Placeholder">
                </div>
                <div class="text-center mt-2">
                    <h4><?php echo $productName; ?></h4>
                </div>
            </a>
        </div>
        <?php
        }
        ?>
    </div>
</div>