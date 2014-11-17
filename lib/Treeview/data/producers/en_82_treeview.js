USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Ortodoncja","/go/_category/?idc=%22id_45%22"))
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_41%22"))
aux2 = insFld(aux1, gFld("Akryle","/go/_category/?idc=%2241_12157%22"))
insDoc(aux2, gLnk("S","Duracrol","/go/_category/?idc=%2241_12157_167%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2241_12157_168%22"))
insDoc(aux2, gLnk("S","Superacryl","/go/_category/?idc=%2241_12157_169%22"))
aux2 = insFld(aux1, gFld("Akryle do licowania","/go/_category/?idc=%2241_12217%22"))
insDoc(aux2, gLnk("S","Duracryl","/go/_category/?idc=%2241_12217_168%22"))
insDoc(aux2, gLnk("S","Superpont","/go/_category/?idc=%2241_12217_177%22"))
insDoc(aux1, gLnk("S","Lakier pokrywajacy","/go/_category/?idc=%2241_12243%22"))
aux1 = insFld(foldersTree, gFld("Stomatologia","/go/_category/?idc=%22id_42%22"))
insDoc(aux1, gLnk("S","Cementy i podk³ady","/go/_category/?idc=%2242_12164%22"))
insDoc(aux1, gLnk("S","Preparaty do dzi±se³ i zêbodo³ów","/go/_category/?idc=%2242_12189%22"))
