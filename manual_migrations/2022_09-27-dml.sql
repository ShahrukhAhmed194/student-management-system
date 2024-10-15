update users set email = SUBSTR(email, 3) where email like 'p_%';


update users u 
join students st on st.user_id = u.id 
join users studentUser on st.user_id = studentUser.id
join users parentUser on st.parent_id = parentUser.id
set studentUser.email = parentUser.email;

