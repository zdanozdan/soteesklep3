USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2259_12385%22"))
aux2 = insFld(aux1, gFld("Endodoncja","/go/_category/?idc=%2259_12373%22"))
insDoc(aux2, gLnk("S","Æwieki papierowe","/go/_category/?idc=%2259_12373_440%22"))
insDoc(aux2, gLnk("S","Gutaperka","/go/_category/?idc=%2259_12373_448%22"))
insDoc(aux1, gLnk("S","Materia³y ³±cz±ce","/go/_category/?idc=%2259_12411%22"))
