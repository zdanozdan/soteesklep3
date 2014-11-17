USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Vyber kategorii","")
aux1 = insFld(foldersTree, gFld("Materia³y inne","/go/_category/?idc=%22id_56%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_50%22"))
insDoc(aux1, gLnk("S","Akryle","/go/_category/?idc=%2250_12270%22"))
insDoc(aux1, gLnk("S","Gipsy","/go/_category/?idc=%2250_12320%22"))
insDoc(aux1, gLnk("S","Silikony","/go/_category/?idc=%2250_12317%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_51%22"))
insDoc(aux1, gLnk("S","Doplòky","/go/_category/?idc=%2251_12282%22"))
insDoc(aux1, gLnk("S","Matreria³y do pod¶cieleñ","/go/_category/?idc=%2251_12357%22"))
insDoc(aux1, gLnk("S","Wype³nienia czasowe","/go/_category/?idc=%2251_12290%22"))
