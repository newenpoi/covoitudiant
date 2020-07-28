function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function lorem_chinese(content)
{
	var grid = ['wong', 'shao', 'nem', 'dang', 'ching', 'doi', 'foi', 'buru', 'nam', 'tong', 'da', 'dong', 'wing', 'guk', 'dak', 'goi', 'fong', 'nem', 'bien', 'van', 'tien', 'xian', 'min', 'buen', 'ding', 'xie', 'ni', 'chong', 'neng', 'hao', 'poi', 'imposi'];
	
	var output = '';
	
	if (content == 'bio')
	{
		var size = 96;
	}
	else
	{
		var size = Math.floor(Math.random() * 32) + 16;
	}
	
	for (var i = 0; i < size; i++)
	{
		let rnd = Math.floor(Math.random() * grid.length) + 0;
		
		(output.length ? (output = output + ' ' + grid[rnd]) : (output = output + ucfirst(grid[rnd])));
	}
	
	output = output + '.';
	
	return output;
}

$(document).ready(function() {
	console.log('Adding some exotic Lorem...');
	
	$('#user-biography').html(lorem_chinese('bio'));
	
	$('.comment').each(function() {
		$(this).html(lorem_chinese('p'));
	});
});