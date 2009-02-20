<div id="admin" class="admin">
    <div class="mesaj">
        <p><?php echo $info.". S-a atins nr.: ".$updatedRecords; ?></p>
    </div>
    <div class="mesaj">
        <p>
            <ul>
            <?php
            foreach($results as $result)
                echo "<li>".$result."</li>";
            ?>
            </ul>
        </p>
    </div>
</div>