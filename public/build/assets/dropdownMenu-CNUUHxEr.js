const n=document.getElementById("dropdown-button"),t=document.getElementById("dropdown-menu");function s(){t.classList.remove("opacity-0","pointer-events-none"),setTimeout(()=>{t.classList.remove("scale-y-0")},10)}function o(){t.classList.add("scale-y-0"),setTimeout(()=>{t.classList.add("opacity-0","pointer-events-none")},200)}n.addEventListener("click",e=>{e.stopPropagation(),t.classList.contains("scale-y-0")?s():o()});document.addEventListener("click",e=>{!t.contains(e.target)&&!n.contains(e.target)&&o()});
