# 献立選択アプリ「献立セレクター」

![ポートフォリオ_1](https://user-images.githubusercontent.com/96277935/188318565-b05862f9-3e42-4a7e-8f67-63f8c9db1964.png)
![ポートフォリオ_2](https://user-images.githubusercontent.com/96277935/188318571-2f1bcb21-5e1e-4342-92b2-5cc9bac38613.png)
![ポートフォリオ_3](https://user-images.githubusercontent.com/96277935/188318577-9b413dfe-1b8d-4ca0-bf25-47e4a74a0d11.png)
![ポートフォリオ_4](https://user-images.githubusercontent.com/96277935/188318582-649cd4a7-4c33-4c45-bbde-63f6ab6d4cd4.png)

## 1. アプリ概要

**献立の選択、登録・管理ができるWeb アプリケーション**です。

URL ▶︎ https://menu-selector.com/

<br>

コロナ禍の影響もあり、日々自炊をしている中で、以下の悩みがありました。


- 毎日何を作るかを考えるのがめんどくさい。

- 中々思い浮かばず、気付いたらすごく時間が経っていた。

<br>

このような悩みを解決したい、という思いでアプリを作成しました。

<br>

## ２. アプリの機能一覧

### メイン機能

-   **献立自動選択機能**（楽天レシピAPI）

※ 以下ユーザー登録要

-   **献立登録**（CRUD 処理）
-   **献立一覧表示**（ページネーション）
-   **献立決定機能**（Createのみ）
-   **献立カレンダー表示**

### 認証機能

-   ユーザー登録・ログイン・ログアウト
-   Google アカウントを使ったユーザー登録・ログイン
-   ゲストログイン
-   プロフィール個別編集（ユーザー名・メールアドレス・パスワード）
-   メールアドレス認証（メールアドレス変更時）
-   パスワード再設定
-   退会

<br>

## ３. 使用技術

### フロントエンド

-   HTML
-   CSS、Sass
-   Bootstrap 5.1.3
-   jQuery 3.6.0

### バックエンド

-   PHP 8.0.20
-   Laravel 8.83.23
-   MySQL 8.0.23
-   PHPUnit

### インフラ

-   Docker 20.10.17 / docker compose 1.29.2
-   AWS (VPC, EC2, RDS, Route53, S3, ACM, IAM, CloudWatch)
-   CircleCI 2.1
-   nginx 1.20

<br>

## 4. インフラ構成図

![インフラ構成図_献立セレクター](https://user-images.githubusercontent.com/96277935/187946252-068bd39a-b4fd-40c4-84b0-03ebe757fe02.png)
