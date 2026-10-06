<?php
    /**
 * Admin Columnsのカテゴリー列を色付きラベルにする。
 */
    function road_to_musha_color_admin_category_column($value, $column, $post_id)
    {
    $screen = get_current_screen();

    // 投稿一覧以外では変更しない。
    if (
        ! $screen ||
        'edit-post' !== $screen->id
    ) {
        return $value;
    }

    // Admin Columnsのカテゴリー列だけを対象にする。
    $column_type = method_exists($column, 'get_type')
        ? $column->get_type()
        : '';

    $column_label = method_exists($column, 'get')
        ? $column->get('label')
        : '';

    if (
        'categories' !== $column_type &&
        'カテゴリー' !== $column_label
    ) {
        return $value;
    }

    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return '未設定';
    }

    $category = $categories[0];

    $category_color = get_field(
        'category_color',
        'category_' . $category->term_id
    );

    if (! $category_color) {
        return esc_html($category->name);
    }

    return sprintf(
        '<span class="road-to-musha-admin-category-label" style="background-color:%s;">%s</span>',
        esc_attr($category_color),
        esc_html($category->name)
    );
    }
    add_filter(
    'ac/column/render',
    'road_to_musha_color_admin_category_column',
    10,
    3
    );

    /**
 * 投稿編集画面に投稿ガイドを表示する。
 */
    function road_to_musha_add_post_guide_meta_box()
    {
    add_meta_box(
        'musha-post-guide',
        '📝 投稿ガイド',
        'road_to_musha_post_guide_meta_box',
        'post',
        'side',
        'high'
    );
    }
    add_action(
    'add_meta_boxes',
    'road_to_musha_add_post_guide_meta_box'
    );

    /**
 * 投稿ガイドの内容を表示する。
 */
    function road_to_musha_post_guide_meta_box()
    {
    ?>
    <div class="musha-post-guide">
        <p>
            新しい記事を追加するときは、以下を確認してください。
        </p>

        <ol>
            <li>
                <strong>タイトル</strong><br>
                記事のタイトルを入力してください。
            </li>

            <li>
                <strong>本文</strong><br>
                記事の内容を入力してください。
            </li>

            <li>
                <strong>カテゴリー</strong><br>
                カテゴリーは<strong>1つだけ</strong>選択してください。
            </li>

            <li>
                <strong>アイキャッチ画像</strong><br>
                推奨サイズは <strong>1200 × 630px</strong> です。
            </li>

            <li>
                <strong>公開前の確認</strong><br>
                タイトル・本文・アイキャッチ画像を確認し、
                「プレビュー」で表示を確認してから公開してください。
            </li>
        </ol>
    </div>
    <?php
        }

        /**
         * 管理画面用CSSを読み込む。
         */
        function road_to_musha_enqueue_admin_styles($hook)
        {
            // 投稿一覧・新規追加・編集画面だけで読み込む。
            if (
                'edit.php' !== $hook &&
                'post.php' !== $hook &&
                'post-new.php' !== $hook
            ) {
                return;
            }

            $admin_style_path = get_template_directory() . '/assets/css/admin.css';

            wp_enqueue_style(
                'musha-admin-style',
                get_template_directory_uri() . '/assets/css/admin.css',
                [],
                file_exists($admin_style_path)
                    ? filemtime($admin_style_path)
                    : wp_get_theme()->get('Version')
            );
        }
        add_action(
            'admin_enqueue_scripts',
            'road_to_musha_enqueue_admin_styles'
        );

        /**
         * 更新担当者の管理画面メニューをシンプルにする。
         */
        function road_to_musha_simplify_admin_menu()
        {
            // 管理者は変更しない。
            if (current_user_can('manage_options')) {
                return;
            }

            // 記事を管理できる更新担当者だけ対象。
            if (! current_user_can('edit_posts')) {
                return;
            }

            // 更新担当者が使用しないメニューを非表示。
            remove_menu_page('edit-comments.php');
            remove_menu_page('themes.php');
            remove_menu_page('plugins.php');
            remove_menu_page('users.php');
            remove_menu_page('tools.php');
            remove_menu_page('options-general.php');
        }
        add_action(
            'admin_menu',
            'road_to_musha_simplify_admin_menu',
            999
        );

        /**
         * 編集者向けにダッシュボードをシンプルにする。
         */
        function road_to_musha_simplify_dashboard()
        {
            // 管理者は変更しない。
            if (current_user_can('manage_options')) {
                return;
            }

            // 投稿を編集できるユーザーだけ対象。
            if (! current_user_can('edit_posts')) {
                return;
            }

            // 「概要」
            remove_meta_box(
                'dashboard_right_now',
                'dashboard',
                'normal'
            );

            // 「アクティビティ」
            remove_meta_box(
                'dashboard_activity',
                'dashboard',
                'normal'
            );

            // 「クイックドラフト」
            remove_meta_box(
                'dashboard_quick_press',
                'dashboard',
                'side'
            );

            // 「WordPress イベントとニュース」
            remove_meta_box(
                'dashboard_primary',
                'dashboard',
                'side'
            );
        }
        add_action(
            'wp_dashboard_setup',
            'road_to_musha_simplify_dashboard',
            999
        );

        /**
         * 編集者向けダッシュボードに記事更新ガイドを追加する。
         */
        function road_to_musha_add_editor_dashboard_widget()
        {
            // 管理者には表示しない。
            if (current_user_can('manage_options')) {
                return;
            }

            // 投稿を編集できるユーザーだけ対象。
            if (! current_user_can('edit_posts')) {
                return;
            }

            wp_add_dashboard_widget(
                'road_to_musha_editor_guide',
                '📝 記事更新ガイド',
                'road_to_musha_editor_dashboard_widget_callback'
            );
        }
        add_action(
            'wp_dashboard_setup',
            'road_to_musha_add_editor_dashboard_widget'
        );

        /**
         * 記事更新ガイドの内容を表示する。
         */
        function road_to_musha_editor_dashboard_widget_callback()
        {
        ?>
    <div class="road-to-musha-dashboard-guide">
        <p>
            記事を追加・更新するときは、以下の流れで作業してください。
        </p>

        <ol>
            <li>
                <strong>投稿を開く</strong><br>
                左メニューの「投稿」から、新しい記事の追加・編集ができます。
            </li>

            <li>
                <strong>タイトル・本文を入力</strong><br>
                記事のタイトルと本文を入力してください。
            </li>

            <li>
                <strong>カテゴリーを選択</strong><br>
                カテゴリーは<strong>1つだけ</strong>選択してください。
            </li>

            <li>
                <strong>アイキャッチ画像を設定</strong><br>
                推奨サイズは <strong>1200 × 630px</strong> です。
            </li>

            <li>
                <strong>公開前に確認</strong><br>
                プレビューで表示を確認してから公開してください。
            </li>
        </ol>

        <p>
            <a
                href="<?php echo esc_url(admin_url('post-new.php')); ?>"
                class="button button-primary"
            >
                新しい記事を追加
            </a>

            <a
                href="<?php echo esc_url(admin_url('edit.php')); ?>"
                class="button"
            >
                記事一覧を見る
            </a>
        </p>
    </div>
    <?php
    }