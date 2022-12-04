<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注文フォーム</title>
   
    @vite('resources/js/app.js')
</head>
<div>
    <label for="prefecture">お届け先</label>
    <select type="text" name="prefecture">
        @foreach (config('prefecture') as $key => $score)
            <option value="{{ $score }}">{{ $score }}</option>
        @endforeach
    </select>
</div>
<div>
    <label for="date">配送希望日
        @if ($option->shortest_delivery_dates === 1)
            <input type="date"id="datefield">
    </label>
    @endif
</div>
<script>
    //日付フォーマットメソッド
    function formatDate(dt) {
        let y = dt.getFullYear();
        let m = ('00' + (dt.getMonth() + 1)).slice(-2);
        let d = ('00' + dt.getDate()).slice(-2);
        return (y + '-' + m + '-' + d);
    }

    //最短配送日表示メソッド
    function deliveryDate(n) {
        let dt = new Date();
        dt.setDate(dt.getDate() + n);
        return formatDate(dt);
    }

    //最短配送日表示
    document.getElementById("datefield").value = deliveryDate(1);
    //最短配送日以前非表示
    document.getElementById("datefield").min = deliveryDate(1);

    //配送希望日の選択肢
    document.getElementById("datefield").max = deliveryDate(1 + 5); 

    baseDate = new Date();
    //現在時刻
    const hours = baseDate.getHours();
    //締め切り時刻
    const timeLimit = 15
    //締め切り時間判定と土日判定
    if(hours > timeLimit && !isHoliday(baseDate)) {
      //最短日を+1日
    document.getElementById("datefield").value = deliveryDate(1 + 1);
    document.getElementById("datefield").min = deliveryDate(1 + 1);
    }

    //土日判定メソッド
    const holiday = ['日', '土'];
    function isHoliday(date) {
      const week = date.getDay();
      const weekStr = ['日', '月', '火', '水', '木', '金', '土'];
      return holiday.includes(weekStr);
    }
</script>
</body>

</html>
