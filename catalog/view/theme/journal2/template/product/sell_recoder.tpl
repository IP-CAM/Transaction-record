
    <table class="table table-bordered attribute">
     <?php if($resultsorders) { ?>
        <thead>
        <tr>
            <td ><strong>买家</strong></td>
            <td ><strong>授权类型</strong></td>
            <td ><strong>交易时间</strong></td>
        </tr>
        </thead>
       <tbody>
        <?php foreach ($resultsorders as $resultsorder) { ?>
       
        <tr>
            <td><?php echo $resultsorder['username']; ?></td>
            <td><?php echo $resultsorder['value']; ?></td>
            <td><?php echo $resultsorder['date_modified']; ?></td>
        </tr>
        
        <?php } ?>
        </tbody>
        <?php } else{ ?>
        <span>暂无交易记录</span>

        <?php } ?>
    </table>
    <div class="text-right"><?php echo $pagination; ?></div>