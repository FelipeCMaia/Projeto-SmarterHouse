
// const target = document.querySelectorAll('[data-anime]');
// const animationClass = 'animate';



// //Função debounce para expecificar um intervalo
// // de tempo entre a execução do método AnimeScroll
// function debounce(func, wait, immediate) {
// 	var timeout;
// 	return function() {
// 		var context = this, args = arguments;
// 		var later = function() {
// 			timeout = null;
// 			if (!immediate) func.apply(context, args);
// 		};
// 		var callNow = immediate && !timeout;
// 		clearTimeout(timeout);
// 		timeout = setTimeout(later, wait);
// 		if (callNow) func.apply(context, args);
// 	};
// };

// //função da animação dos elementos
// function animeScroll(){
//  const windowTOP = window.pageYOffset + ((window.innerHeight * 3) / 3.9);
//  target.forEach(function(elementos){
//      if(windowTOP> elementos.offsetTop){
//          elementos.classList.add(animationClass);
         
//      }
//      else{
//         elementos.classList.remove(animationClass);
//     }
    
//  })    
// }
// //chama a função quando o usua´rio entra no site
// animeScroll();

// //Verifica se existe algum elemento com a propriedade data-anime
// if(target.length){
//     //chama a função com delay de 100 ms
//     window.addEventListener('scroll' , debounce(function(){
//         animeScroll();
//     }, 150));
// 	window.scrollX = animeScroll();
// 	window.scrollY = animeScroll();
// }

