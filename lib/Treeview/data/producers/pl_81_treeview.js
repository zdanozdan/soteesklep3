USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Wybierz kategorie","")
aux1 = insFld(foldersTree, gFld("Materia³y inne","/go/_category/?idc=%22id_49%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2241_12157%22"))
insDoc(aux1, gLnk("S","Gipsy","/go/_category/?idc=%2241_12206%22"))
insDoc(aux1, gLnk("S","Silikony","/go/_category/?idc=%2241_12203%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
insDoc(aux1, gLnk("S","Akcesoria","/go/_category/?idc=%2242_12168%22"))
insDoc(aux1, gLnk("S","Matreria³y do pod¶cieleñ","/go/_category/?idc=%2242_12244%22"))
insDoc(aux1, gLnk("S","Wype³nienia czasowe","/go/_category/?idc=%2242_12176%22"))
