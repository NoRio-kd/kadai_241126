<form action="insert.php" method="post">
    
    <!-- 1 -->
    日付     
    <div>
        <input type="date" name="day" list="daylist" min="">
        <!-- list属性は<datalist>タグと連携して、入力フィールドに候補のリストを表示する -->
    </div>
    <!-- 2 -->
    人数
    <div>
        <input name="member">
        <!-- 大人<input name="adult">
        子供<input name="child"> -->
    </div>

    <!-- 3 -->
    お名前
    <div>
        <input type="text" name="name" placeholder="Micheal Jackson">
    </div>
    
    <!-- 4 -->
    電話番号
    <div>
        <input type="tel" name="number" placeholder="08012349876">
    </div>
    
    <!-- 5 -->
    備考
    <div>
        <textarea name="remark" rows="4" cols="40"></textarea>
    </div>

    <div class="submit">
        <input type="submit" value="送信">
    </div>
    
    <div class="reset">
        <input type="reset" value="リセット">
    </div>
</form>