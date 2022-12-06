<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注文フォーム</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @vite('resources/js/app.js')
</head>

<div>
  <form action="{{ url('/option') }}" method="POST">
    @csrf
    <div class="flex items-center ml-4 my-8">
      <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80" type="submit" name="option" value="1">管理者設定1</button> <p>（最短配送翌日、選択肢5、15以降でも翌日配送、土日配送可、北海道+2日、沖縄+3日の設定値）</p>
    </div>
    <div class="flex items-center ml-4 mt-8 mb-16 ">
      <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80" type="submit" name="option" value="2">管理者設定2</button> <p>（最短配送翌々日、選択肢10、15時以降+1日、土日配送不可、北海道+3日、沖縄+3日の設定値）</p>
    </div>
    
  </form>
</div>

<div class="bg-blue-300 flex items-center px-6 py-4 mx-auto overflow-x-auto whitespace-nowrap">
  <span class="mx-5 text-lg font-bold text-gray-800 rtl:-scale-x-100">商品配送先・配送日時</span>
</div>

<div class="container px-16">
<div class="my-16">
    <label for="prefecture" class="block mb-2 text-sm font-bold text-gray-900">お届け先</label>
    <select type="text" name="prefecture" id="prefecture"  required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
        <option value="" selected disabled>選択してください</option>
        @foreach (config('prefecture') as $key => $score)
            <option value="{{ $key }}">{{ $score }}</option>
        @endforeach
    </select>
</div>

<div class="my-16">
    <label for="delivery_dates" class="block mb-2 text-sm font-bold text-gray-900">配送希望日:</label>
    <select type="text" name="delivery_dates" id="delivery_dates" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
        @foreach ($delivery_dates as $key => $delivery_date)
            <option value="{{ $key }}">{{ $delivery_date }}</option>
        @endforeach
    </select>  
</div>
<button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">注文する</button>
</div>

<script>
    //都道府県選択検知
    $("#prefecture").on('change', function() {
        let prefecture = $(this).val();
        let option = @json($option);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/prefecture",
            dataType: "json",
            data: {
                opt: option,
                pre: prefecture,
            },
            //option要素再生成
        }).done(function(delivery_dates) {
            $('#delivery_dates option').remove();
            $.each(delivery_dates, function(key, delivery_date) {
                $('#delivery_dates').append($('<option>').html(delivery_date).val(
                    delivery_date));
            })
            // //通信成功
            // .then((delivery_dates) => {
            //   console.table(delivery_dates);
            // })
            // //通信失敗
            // .fail((error) => {
            //   console.log(error.statusText);
            // });
        })
    })
    // baseDate = new Date();
    // //現在時刻
    // const hours = baseDate.getHours();
    // //締め切り時刻
    // const timeLimit = 15;

    // //datepicker呼び出し
    // $('#datepicker').datepicker({
    //     dateFormat: 'yy-mm-dd',
    //     //最短配送日
    //     minDate: 'd',
    //     //表示選択肢数
    //     maxDate: 'minDate+5',
    //     beforeShowDay: function(date) {
    //         if (hours > timeLimit || date.getDay() == 0 || date.getDay() == 6) {
    //             //土日選択不可
    //             return [false, 'ui-state-disabled'];
    //         } else if() {
    //         } else {
    //             //平日選択可
    //             return [true, ''];
    //         }
    //     }
    // });
    // //日付フォーマットメソッド
    // function formatDate(dt) {
    //     let y = dt.getFullYear();
    //     let m = ('00' + (dt.getMonth() + 1)).slice(-2);
    //     let d = ('00' + dt.getDate()).slice(-2);
    //     return (y + '-' + m + '-' + d);
    // }

    // //最短配送日表示メソッド
    // function deliveryDate(n) {
    //     let dt = new Date();
    //     dt.setDate(dt.getDate() + n);
    //     return formatDate(dt);
    // }

    // //最短配送日表示
    // document.getElementById("datefield").value = deliveryDate(1);
    // //最短配送日以前非表示
    // document.getElementById("datefield").min = deliveryDate(1);

    // //配送希望日の選択肢
    // document.getElementById("datefield").max = deliveryDate(1 + 5); 

    // baseDate = new Date();
    // //現在時刻
    // const hours = baseDate.getHours();
    // //締め切り時刻
    // const timeLimit = 15
    // //締め切り時間判定と土日判定
    // if(hours > timeLimit && !isHoliday(baseDate)) {
    //   //最短日を+1日
    // document.getElementById("datefield").value = deliveryDate(1 + 1);
    // document.getElementById("datefield").min = deliveryDate(1 + 1);
    // }

    // //土日判定メソッド
    // const holiday = ['日', '土'];
    // function isHoliday(date) {
    //   const week = date.getDay();
    //   const weekStr = ['日', '月', '火', '水', '木', '金', '土'];
    //   return holiday.includes(weekStr);
    // }
</script>
</body>

</html>
