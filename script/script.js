let para = document.getElementById('test1')
let body = document.getElementById('body')
let div = document.getElementById('test2')
let span = document.getElementById('span')
let span2 = document.getElementById('span2')
let trie = document.getElementById('trie')
let profil = document.getElementById('profil')
let none = document.getElementById('none')
let none1 = document.getElementById('none1_id')
let none2 = document.getElementById('none2_id')
let none3 = document.getElementById('none3_id')
let button = document.getElementById('button1')


button.addEventListener('click', () => {
   none3.classList.add('index')
})


none1.addEventListener('click', () => {
   none.classList.remove('margin')
   none3.classList.remove('index')
   none1.classList.remove('flou')

})
para.addEventListener('click', () => {
   div.classList.add('test')
})
profil.addEventListener('click', () => {
   none.classList.add('margin')
   none1.classList.add('flou')
})

div.addEventListener('click', () => {
   div.classList.remove('test')

})

span.addEventListener('click', () => {
   span2.classList.toggle('reverse')
   trie.classList.toggle('magie')

})


