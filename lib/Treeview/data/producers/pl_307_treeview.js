USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2259_12385%22"))
insDoc(aux1, gLnk("S","Materia³y ³±cz±ce","/go/_category/?idc=%2259_12411%22"))
aux2 = insFld(aux1, gFld("Systemy do polerowania","/go/_category/?idc=%2259_12375%22"))
insDoc(aux2, gLnk("S","Kr±¿ki","/go/_category/?idc=%2259_12375_419%22"))
insDoc(aux2, gLnk("S","Mandrylki","/go/_category/?idc=%2259_12375_420%22"))
insDoc(aux2, gLnk("S","Pasta polerska","/go/_category/?idc=%2259_12375_372%22"))
insDoc(aux1, gLnk("S","Wype³nienia","/go/_category/?idc=%2259_12371%22"))
