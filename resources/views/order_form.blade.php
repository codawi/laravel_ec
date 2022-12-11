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
  <form action="{{ url('/set_value') }}" method="POST">
    @csrf
    <div class="flex items-center ml-4 my-8">
      <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80" type="submit" name="set_value_id" value="1">管理者設定1</button> <p>（最短配送翌日、選択肢5、15以降でも翌日配送、土日配送可、北海道+2日、沖縄+3日の設定値）</p>
    </div>
    <div class="flex items-center ml-4 mt-8 mb-16 ">
      <button class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80" type="submit" name="set_value_id" value="2">管理者設定2</button> <p>（最短配送翌々日、選択肢10、15時以降最短配送日+1日、土日配送不可、北海道+3日、沖縄+3日の設定値）</p>
    </div>
    
  </form>
</div>

<div class="bg-blue-300 flex items-center px-6 py-4 mx-auto overflow-x-auto whitespace-nowrap">
  <span class="mx-5 text-lg font-bold text-gray-800 rtl:-scale-x-100">商品配送先・配送日時(管理者設定{{ $set_value_id }})</span>
</div>

<div class="container px-16">
<div class="my-16">
    <label for="prefecture" class="block mb-2 text-sm font-bold text-gray-900">お届け先:</label>
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
        let set_value_id = @json($set_value_id);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "post",
            url: "/prefecture",
            dataType: "json",
            data: {
                pre: prefecture,
                value: set_value_id,
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
</script>
</body>

</html>
