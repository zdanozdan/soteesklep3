USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Kategorie w�hlen","")
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_59%22"))
insDoc(aux1, gLnk("S","Cementy i podk�ady","/go/_category/?idc=%2259_12385%22"))
insDoc(aux1, gLnk("S","Masy wyciskowe","/go/_category/?idc=%2259_12383%22"))
insDoc(aux1, gLnk("S","Materia�y ��cz�ce","/go/_category/?idc=%2259_12411%22"))
insDoc(aux1, gLnk("S","Materia�y na korony tymczasowe","/go/_category/?idc=%2259_12453%22"))
insDoc(aux1, gLnk("S","Systemy do polerowania","/go/_category/?idc=%2259_12375%22"))
aux2 = insFld(aux1, gFld("Wype�nienia","/go/_category/?idc=%2259_12371%22"))
insDoc(aux2, gLnk("S","Glassjonomery","/go/_category/?idc=%2259_12371_481%22"))
insDoc(aux2, gLnk("S","�wiat�outwardzalne","/go/_category/?idc=%2259_12371_403%22"))
insDoc(aux1, gLnk("S","Wype�nienia czasowe","/go/_category/?idc=%2259_12397%22"))
insDoc(aux1, gLnk("S","�ar�wki","/go/_category/?idc=%2259_12390%22"))
