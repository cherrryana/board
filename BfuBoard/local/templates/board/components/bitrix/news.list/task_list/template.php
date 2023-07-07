<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

$this->setFrameMode(true);
?>
<?php
?>
<body class="page__body">



<?php if(!$arResult['CURRENT_TEAM']):?>
    <h2 class="category__title category__title--not-done">У вас пока нет команды. Попросите, чтобы вас пригласили!</h2>

<?php elseif(!$arResult['BOARD_ALLOWED']):?>
    <h2 class="category__title category__title--not-done">Такой доски нет, или вам на неё нельзя!</h2>
<?php endif?>
<main class="page__main task-board">
        <? $index = 0;
		foreach ($arResult['CURRENT_STRUCTURE'] as $key => $section):?>
            <section class="task-board__category category category--<?=$arResult['VISUAL_PREF'][$index]?>">
                <h2 class="category__title category__title--<?=$arResult['VISUAL_PREF'][$index]?>"><?=$section['NAME']?></h2>
                <ul class="category__task-list task-list">
                    <?foreach ($section['ELEMENTS'] as $j => $item):?>
                        <li data-status-id="<?=$section['ID']?>" data-item-id="<?=$item['ID']?>" class="task-card task-toggle">
                            <?foreach ($item['PROPERTIES']['TASK_TAG']['VALUE'] as $tag):?>
                                <span class="task-card__theme"><?=$tag?></span>
                                <span class="task-card__icon"></span>
                            <?endforeach;?>
                            <h3 class="task-card__title"><?=$item['NAME']?></h3>
                            <p class="task-card__description"><?=$item['DETAIL_TEXT']?></p>
                            <div class="task-card__attachment"></div>
                            <span class="task-card__date"><?=$item['PROPERTIES']['DATE_END']['VALUE']?></span>
                        </li>
                    <?endforeach;?>
                </ul>
                <button data-status-id="<?=$section['ID']?>" class="category__new-task-toggle new-task-toggle">Создать новое задание</button>
            </section>
        <?$index++;
		endforeach;?>
	<!-- Popups -->
	<div class="popup-container">
		<section class="popup popup--new-board">
			<h2 class="popup__title">Создание новой доски</h2>
			<button class="popup__close-toggle new-board-toggle" type="button"></button>
			<form id="new_board" class="form" action="local/ajax/new_board.php" method="post">
				<label class="form__label">
					<span class="visually-hidden">Название доски</span>
					<input class="form__input" type="text" name="new-board-name" placeholder="Введите название" maxlength="70" required>
				</label>
                <input class="form__input" type="hidden" name="team_id" value="<?=$arResult['CURRENT_TEAM']?>">

				<button class="button button--create" name="new-board" type="submit">Создать</button>
			</form>
		</section>
		<section class="popup popup--new-member">
			<h2 class="popup__title">Добавить участника</h2>
			<button class="popup__close-toggle new-member-toggle" type="button"></button>
			<form id="invite" class="form" action="local/ajax/invite_member.php" method="post">
				<label class="form__label">
					<span class="visually-hidden">Имя пользователя</span>
					<input class="form__input" type="email" name="email-to" placeholder="Введите email участника" required>
				</label>
				<input type="hidden" name="team-name" value="<?=$arResult['CURRENT_TEAM_NAME']?>">
				<input type="hidden" name="team-id" value="<?=$arResult['CURRENT_TEAM']?>">
				<button class="button" type="submit">Добавить</button>
			</form>
		</section>
		<section class="popup popup--new-task">
			<h2 class="popup__title popup__title--new-task">Создайте новое задание</h2>
			<button class="popup__close-toggle new-task-toggle" type="button"></button>
			<form id="create_task" class="form" action="local/ajax/board_change.php" method="post">
				<div class="form__group" role="group">
				</div>
				<label class="form__label">
					<span class="form__input-title">Заголовок задачи</span>
					<input class="form__input" type="text" name="task-name" placeholder="Введите заголовок задачи" maxlength="150" required>
				</label>
				<label class="form__label">
					<span class="form__input-title">Описание</span>
					<textarea class="form__input form__input--textarea" name="task-description" placeholder="Введите описание"></textarea>
				</label>
				<label class="form__label">
					<span class="form__input-title">Дата</span>
					<input class="form__input" type="text" name="task-date" pattern="\d{2}.\d{2}.2\d{3}" placeholder="Введите дату" required>
				</label>
				<label class="form__label">
					<span class="form__input-title">Статус</span>
					<select class="form__input new-task-select" name="task-status">
						<?
						$counter = 0;
						foreach ($arResult['CURRENT_STRUCTURE'] as $key => $section):?>
							<option value="<?=$section['ID']?>" <?if(!$counter):?>selected <?endif?> > <?=$section['NAME']?></option>
							<?$counter++;
						endforeach;?>
					</select>
				</label>
				<button name="create_task" class="form__submit-button button button--save" type="submit">Сохранить</button>
				<input class="form__input" type="hidden" name="operation" value="create">
			</form>
		</section>
		<section data-update-id="" class="popup popup--task">
			<h2 class="popup__title popup__title--task">Настройки</h2>
			<button class="popup__close-toggle task-toggle" type="button"></button>
			<form id="update_task" name="update_task" class="form" action="local/ajax/board_change.php" method="post">
				<div class="form__group" role="group">
				</div>
				<label class="form__label">
					<span class="form__input-title">Заголовок задачи</span>
					<input class="form__input" type="text" name="task-name" placeholder="Введите заголовок задачи" maxlength="150" required>
				</label>
				<label class="form__label">
					<span class="form__input-title">Описание</span>
					<textarea class="form__input form__input--textarea" name="task-description" placeholder="Введите описание"></textarea>
				</label>
				<label class="form__label">
					<span class="form__input-title">Дата</span>
					<input class="form__input" type="text" name="task-date" placeholder="Введите дату" required>
				</label>
				<label class="form__label">
					<span class="form__input-title">Статус</span>
					<select class="form__input new-task-select" name="task-status">
						<?
						$counter = 0;
						foreach ($arResult['CURRENT_STRUCTURE'] as $key => $section):?>
							<option value="<?=$section['ID']?>" <?if(!$counter):?>selected <?endif?> ><?=$section['NAME']?></option>
						<?$counter++;
						endforeach;?>
					</select>
				</label>
				<input class="form__input" type="hidden" name="operation" value="change">
				<input class="form__input" type="hidden" name="id" value="">
				<button name="update_task" class="form__submit-button button button--save" type="submit">Сохранить</button>
			</form>
		</section>
	</div>
</main>
</body>
</html>