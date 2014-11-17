USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
insDoc(aux1, gLnk("S","Materia³y ³±cz±ce","/go/_category/?idc=%2242_12190%22"))
aux2 = insFld(aux1, gFld("Systemy do polerowania","/go/_category/?idc=%2242_12155%22"))
insDoc(aux2, gLnk("S","Kr±¿ki","/go/_category/?idc=%2242_12155_187%22"))
insDoc(aux2, gLnk("S","Mandrylki","/go/_category/?idc=%2242_12155_188%22"))
insDoc(aux1, gLnk("S","Wype³nienia","/go/_category/?idc=%2242_12151%22"))
