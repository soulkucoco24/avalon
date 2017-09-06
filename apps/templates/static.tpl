{include file="widget/nav.tpl"}


<div id="canvas_placeholder">
    {if $data == 'STATIC_RULE_AVALON'}
    	<font>【规则】阿瓦隆规则 

			故事背景来自亚瑟王传说，大法师梅林。 两方对抗性桌游，适合5-10人游戏。

			好人（蓝方）人物及能力： 
			1、 梅林：初始知道所有坏人（不含莫德雷德） 
			2、 派西维尔：初始知道梅林和莫甘娜 
			3、 兰斯洛特*好（扩展包）：可能发生阵营转换 
			4、 亚瑟的忠臣：无特殊能力好人 

			坏人（红方）人物及能力： 
			5、 莫德雷德：梅林看不到他 
			6、 莫甘娜：假扮梅林，迷惑派西维尔 
			7、 奥伯伦：看不到其他坏人，其他坏人也看不到他 
			8、 兰斯洛特*坏（扩展包）：初始被梅林看到，他看不到别的坏人，别的坏人可以看到他，可能发生阵营转换，任务卡只能出任务失败 
			9、 刺客：在三次任务成功后，可以刺杀梅林，如成功，坏人胜利。 
			10、 莫德雷德的爪牙：无特殊能力坏人 

			标准包建议配置： 
			1、5人：梅林、派西维尔、忠臣 vs 莫甘娜、刺客 
			2、6人：梅林、派西维尔、忠臣*2 vs 莫甘娜、刺客 
			3、7人：梅林、派西维尔、忠臣*2 vs 莫甘娜、奥伯伦、刺客 
			4、8人：梅林、派西维尔、忠臣*3 vs 莫甘娜、刺客、爪牙 
			5、9人：梅林、派西维尔、忠臣*4 vs 莫德雷德、莫甘娜、刺客 
			6、10人：梅林、派西维尔、忠臣*4 vs 莫德雷德、莫甘娜、奥伯伦、刺客 

			扩展包建议配置： 略

			胜负判定：一局游戏一共设置5个任务，出现3个任务失败时，坏人直接胜利，出现3个任务成功时，刺客如杀对梅林，则坏人胜利，否则好人胜利。好坏兰斯洛特的胜利条件根据游戏结束时自己的所属阵营来定。 

			任务执行：所有玩家随机选择一个人作为初始的队长，队长根据5个任务规定的人数，选择相应数量的玩家组队，可以包含自己也可以不包含自己。选定队员后，从队长的右手边开始逆时针发言，队长可以选择第一个发言，或者最后一个发言。发言仅一轮，完毕后，所有玩家投票选择同意组队还是反对组队，不可弃权，所有玩家同时亮出答案，如同意组队的人数超过玩家总数的一半，则任务可以执行，等于或者小于一半时任务被延迟一次。 

			延迟：任务被延迟后，不视为执行，可重新选择这个任务，但一局游戏任务只能出现4次延迟，此后队长无论如何选择队员，任务都必须执行。 

			任务结果：任务执行时，所有队员从任务成功和失败中选择一个秘密给出，好人必须出成功，坏人可以选择出成功或失败，兰斯洛特*坏必须出失败。所有队员的结果将牌洗混后公布，根据其中的成功和失败牌的数量来判断任务成功或失败。 

			任务人数要求（任务为虚拟，执行任务只是玩家打出任务成功或失败卡）： 
			1、5人：2-3-2-3-3（均为出现一个任务失败就判定为任务失败） 
			2、6人：2-3-4-3-4（均为出现一个任务失败就判定为任务失败） 
			3、7人：2-3-3-4-4（第一个4人任务需要出现两个任务失败才判定为失败，其余只需要一个） 
			4、8-10人：3-4-4-5-5（第一个5人任务需要出现两个任务失败才判定为失败，其余只需要一个） 

			游戏进程： 
			天黑阶段： 
			1、 梅林睁眼，所有坏人举手（除了莫德雷德） 
			2、 奥伯伦和兰斯洛特*坏以外的坏人睁眼，互相辨认同伴，兰斯洛特*坏只举手不睁眼 
			3、 派西维尔睁眼，梅林和莫甘娜举手 
			天亮阶段： 
			1、 随机（如非第一次游戏，则以上局最后一个队长的左手玩家为首任队长）选择一个玩家担任队长，队长从5个任务中选择一个，再选定足够人数的队员，进行发言和投票，决定任务执行或延迟。
			2、 队长左手边的玩家为下一个队长，不断重复，直到出现三次任务成功或失败为游戏结束。 
			胜负判定阶段： 
			1、 出现三次任务失败时坏人直接胜利 
			2、 出现三次任务成功时所有玩家禁言，所有坏人举手声明自己是坏人，讨论梅林人选，并确定一个玩家刺杀，如被刺杀的是梅林，则坏人胜利，否则好人胜利 

			　　卡牌之一：亚瑟的忠臣，共有五张。游戏中抽到这些卡牌的玩家基本上就注定了本局游戏要做一个不平凡的路人甲或宋兵乙。

			　　卡牌之二：莫德雷德的爪牙，共三张，他们也就是大家常说的坏人。笔者总感觉，《抵抗组织》系列里做坏人比做好人有趣。

			　　卡牌之三：具有特殊功能的卡牌，都是在亚瑟王传说中有名有姓的人物，包括圣骑士派西维尔（帕西瓦尔）、梅林、奥伯伦（梅林他爸）、刺客（坏蛋最后的希望）、莫德雷德和莫甘娜（摩根）。其中梅林和刺客是每次游戏都必须带的，其他角色可根据需要添加。充满了特色的人物使得《阿瓦隆》相比《抵抗组织》要好玩不少。
		</font>
    {/if}
</div>

