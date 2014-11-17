USETEXTLINKS=1
STARTALLOPEN=0
USEFRAMES=0
USEICONS=0
WRAPTEXT=1
PERSERVESTATE=1
ICONPATH="/lib/Treeview/"

foldersTree = gFld("Choose category","")
aux1 = insFld(foldersTree, gFld("Protetyka","/go/_category/?idc=%22id_32%22"))
insDoc(aux1, gLnk("S","Narzêdzia rêczne","/go/_category/?idc=%2232_12077%22"))
aux2 = insFld(aux1, gFld("Woski","/go/_category/?idc=%2232_12081%22"))
insDoc(aux2, gLnk("S","Woski do modelowania","/go/_category/?idc=%2232_12081_43%22"))
insDoc(aux2, gLnk("S","Woski na protezy szkieletowe","/go/_category/?idc=%2232_12081_46%22"))
