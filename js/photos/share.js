$(function (){
    var json = Cookies.get('share-list');
    var list = json && json.length > 5 ? JSON.parse(json) : undefined;
    if (!list) list = [];
    console.log('List', list);
    $('#wa-selected').html(list.length);
    $('input.share[data-share]').on('change', function (e){
        var input = $(this);
        var share = $(this).data('share');
        if (input.is(':checked')){
            list.push(share);
        } else {
            list = list.filter(data => data != share);
        }
        console.log($(this).data('share'), list);
        Cookies.set('share-list', JSON.stringify(list));
        $('#wa-selected').html(list.length);
    }).each((i, e) => $(e).prop('checked', list.includes($(e).data('share'))));
});