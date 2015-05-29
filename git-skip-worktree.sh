#!/bin/sh

git update-index --skip-worktree application/config/config.php
git update-index --skip-worktree application/config/database.php
git update-index --skip-worktree application/config/email.php
git update-index --skip-worktree application/config/ion_auth.php

